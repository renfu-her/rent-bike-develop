<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * 處理結帳並導向綠界金流
     */
    public function process(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'payment_method' => 'required|in:credit_card,atm',
            'invoice_type' => 'required|in:personal,company',
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        
        // 檢查購物車是否為當前用戶的
        if ($cart->member_id !== auth('member')->id()) {
            return back()->with('error', '無權限操作此購物車');
        }

        // 檢查購物車是否為空
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', '購物車是空的！');
        }

        // 檢查機車是否仍可預約
        $cartDetails = $cart->cartDetails()->with('motorcycle')->get();
        foreach ($cartDetails as $detail) {
            if ($detail->motorcycle->status !== 'available') {
                return back()->with('error', '機車 ' . $detail->motorcycle->name . ' 目前無法預約');
            }
        }

        // 創建訂單
        $order = Order::create([
            'store_id' => $cartDetails->first()->motorcycle->store_id, // 使用第一個機車的商店
            'member_id' => auth('member')->id(),
            'total_price' => $cart->total_amount,
            'rent_date' => $cartDetails->first()->rent_date, // 使用第一個項目的租車日期
            'return_date' => $cartDetails->first()->return_date, // 使用第一個項目的還車日期
            'is_completed' => false,
            'order_no' => Order::generateOrderNo(),
        ]);

        // 創建訂單明細並更新機車狀態
        foreach ($cartDetails as $detail) {
            OrderDetail::create([
                'order_id' => $order->id,
                'motorcycle_id' => $detail->motorcycle_id,
                'quantity' => $detail->quantity,
                'subtotal' => $detail->subtotal,
                'total' => $detail->subtotal,
            ]);

            // 更新機車狀態為已出租
            $detail->motorcycle->update(['status' => 'rented']);
        }

        // 清空購物車
        $cart->clear();
        $cart->update(['status' => 'completed']);

        // 準備綠界金流參數
        $ecpayParams = $this->prepareEcpayParams($order, $request->payment_method);

        // 導向綠界金流
        return view('payment.redirect', compact('ecpayParams'));
    }

    /**
     * 準備綠界金流參數
     */
    private function prepareEcpayParams($order, $paymentMethod)
    {
        $merchantId = config('services.ecpay.merchant_id', '2000132'); // 測試環境
        $hashKey = config('services.ecpay.hash_key', '5294y06JbISpM5x9'); // 測試環境
        $hashIV = config('services.ecpay.hash_iv', 'v77hoKGq4kWxNNIS'); // 測試環境
        $paymentUrl = config('services.ecpay.payment_url', 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5');

        // 商品名稱
        $itemNames = [];
        foreach ($order->orderDetails as $detail) {
            $itemNames[] = $detail->motorcycle->name;
        }
        $itemName = implode('#', $itemNames);

        // 基本參數
        $params = [
            'MerchantID' => $merchantId,
            'MerchantTradeNo' => $order->order_no,
            'MerchantTradeDate' => now()->format('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => (int)$order->total_price,
            'TradeDesc' => '機車出租服務',
            'ItemName' => $itemName,
            'ReturnURL' => route('payment.notify'),
            'ClientBackURL' => route('orders.index'),
            'OrderResultURL' => route('payment.result'),
            'ChoosePayment' => $paymentMethod === 'credit_card' ? 'Credit' : 'ATM',
            'EncryptType' => 1,
        ];

        // 計算檢查碼
        $params['CheckMacValue'] = $this->generateCheckMacValue($params, $hashKey, $hashIV);

        return [
            'paymentUrl' => $paymentUrl,
            'params' => $params,
        ];
    }

    /**
     * 生成綠界檢查碼
     */
    private function generateCheckMacValue($params, $hashKey, $hashIV)
    {
        // 移除 CheckMacValue 參數
        unset($params['CheckMacValue']);

        // 參數排序
        ksort($params);

        // 組合參數字串
        $queryString = http_build_query($params);

        // 加入 HashKey 和 HashIV
        $queryString = 'HashKey=' . $hashKey . '&' . $queryString . '&HashIV=' . $hashIV;

        // URL Encode
        $queryString = urlencode($queryString);

        // 轉小寫
        $queryString = strtolower($queryString);

        // SHA256 加密
        $checkMacValue = hash('sha256', $queryString);

        return strtoupper($checkMacValue);
    }

    /**
     * 綠界付款結果通知 (Server to Server)
     */
    public function notify(Request $request)
    {
        Log::info('綠界付款通知', $request->all());

        // 驗證檢查碼
        $checkMacValue = $request->input('CheckMacValue');
        $hashKey = config('services.ecpay.hash_key', '5294y06JbISpM5x9');
        $hashIV = config('services.ecpay.hash_iv', 'v77hoKGq4kWxNNIS');

        // 重新計算檢查碼
        $params = $request->except('CheckMacValue');
        ksort($params);
        $queryString = http_build_query($params);
        $queryString = 'HashKey=' . $hashKey . '&' . $queryString . '&HashIV=' . $hashIV;
        $queryString = urlencode($queryString);
        $queryString = strtolower($queryString);
        $calculatedCheckMacValue = strtoupper(hash('sha256', $queryString));

        if ($checkMacValue !== $calculatedCheckMacValue) {
            Log::error('綠界檢查碼驗證失敗', [
                'received' => $checkMacValue,
                'calculated' => $calculatedCheckMacValue,
            ]);
            return '0|ErrorMessage';
        }

        // 更新訂單狀態
        $orderNo = $request->input('MerchantTradeNo');
        $paymentResult = $request->input('RtnCode');
        
        $order = Order::where('order_no', $orderNo)->first();
        
        if ($order) {
            if ($paymentResult === '1') {
                // 付款成功
                $order->update(['is_completed' => true]);
                Log::info('訂單付款成功', ['order_no' => $orderNo]);
            } else {
                // 付款失敗，恢復機車狀態
                foreach ($order->orderDetails as $detail) {
                    $detail->motorcycle->update(['status' => 'available']);
                }
                Log::warning('訂單付款失敗', ['order_no' => $orderNo, 'result' => $paymentResult]);
            }
        }

        // 回應綠界
        return '1|OK';
    }

    /**
     * 付款結果頁面 (Client 端)
     */
    public function result(Request $request)
    {
        $orderNo = $request->input('MerchantTradeNo');
        $paymentResult = $request->input('RtnCode');
        
        $order = Order::where('order_no', $orderNo)->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', '找不到訂單');
        }

        if ($paymentResult === '1') {
            return redirect()->route('orders.index')->with('success', '付款成功！訂單編號：' . $orderNo);
        } else {
            return redirect()->route('orders.index')->with('error', '付款失敗，請重新嘗試');
        }
    }
}
