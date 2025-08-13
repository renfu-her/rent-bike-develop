<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Cart;

class PaymentController extends Controller
{
    /**
     * 處理付款請求
     */
    public function process(Request $request)
    {
        $cartId = $request->input('cart_id');
        $paymentMethod = $request->input('payment_method', 'credit_card');

        $cart = Cart::findOrFail($cartId);
        $cartDetails = $cart->cartDetails()->with('motorcycle')->get();

        if ($cartDetails->isEmpty()) {
            return redirect()->route('cart.index')->with('error', '購物車是空的！');
        }

        // 創建訂單
        $order = $this->createOrder($cart, $cartDetails);

        // 準備綠界金流參數
        $paymentData = $this->prepareEcpayData($order, $paymentMethod);

        // 返回綠界付款表單
        return view('payment.ecpay_form', $paymentData);
    }

    /**
     * 創建訂單
     */
    private function createOrder($cart, $cartDetails)
    {
        $member = auth('member')->user();

        // 開始資料庫交易
        DB::beginTransaction();

        try {
            // 檢查機車可用性並更新狀態
            foreach ($cartDetails as $cartDetail) {
                $motorcycle = $cartDetail->motorcycle;

                if ($motorcycle->status !== 'available') {
                    throw new \Exception("機車 {$motorcycle->name} 目前無法預約");
                }

                $motorcycle->update(['status' => 'pending_checkout']);
            }

            // 創建訂單
            $order = Order::create([
                'store_id' => $cartDetails->first()->motorcycle->store_id,
                'member_id' => $member->id,
                'total_price' => $cart->total_amount,
                'rent_date' => $cartDetails->first()->rent_date,
                'return_date' => $cartDetails->first()->return_date,
                'is_completed' => false,
                'order_no' => Order::generateOrderNo(),
            ]);

            // 創建訂單明細
            foreach ($cartDetails as $cartDetail) {
                \App\Models\OrderDetail::create([
                    'order_id' => $order->id,
                    'motorcycle_id' => $cartDetail->motorcycle_id,
                    'quantity' => $cartDetail->quantity,
                    'subtotal' => $cartDetail->subtotal,
                    'total' => $cartDetail->subtotal,
                ]);
            }

            // 清空購物車
            $cart->clear();

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * 準備綠界金流參數
     */
    private function prepareEcpayData($order, $paymentMethod)
    {
        // 綠界測試環境設定
        $merchantId = '3002607'; // 測試特店編號
        $hashKey = 'pwFHCqoQZGmho4w6'; // 測試 HashKey
        $hashIV = 'EkRm7iFT261dpevs'; // 測試 HashIV
        $paymentUrl = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

        // 商品名稱
        $itemName = '';
        foreach ($order->orderDetails as $detail) {
            $itemName .= $detail->motorcycle->name . '#' . $detail->motorcycle->model . '#';
        }
        $itemName = rtrim($itemName, '#');

        // 準備參數
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

        // 調試用：顯示參數
        // dd($paymentUrl, $params, $hashKey, $hashIV);

        return [
            'paymentUrl' => $paymentUrl,
            'params' => $params,
        ];
    }

    /**
     * 生成綠界檢查碼
     * 參考：https://gist.github.com/liaosankai/7aada599848ad599529fd5fdfa7926e6
     */
    private function generateCheckMacValue(array $params, $hashKey, $hashIV)
    {
        // 0) 如果資料中有 null，必需轉成空字串
        $params = array_map('strval', $params);

        // 1) 如果資料中有 CheckMacValue 必需先移除
        unset($params['CheckMacValue']);

        // 2) 將鍵值由 A-Z 排序
        uksort($params, 'strcasecmp');

        // 3) 將陣列轉為 query 字串
        $paramsString = urldecode(http_build_query($params));

        // 4) 最前方加入 HashKey，最後方加入 HashIV
        $paramsString = "HashKey={$hashKey}&{$paramsString}&HashIV={$hashIV}";

        // 5) 做 URLEncode
        $paramsString = urlencode($paramsString);

        // 6) 轉為全小寫
        $paramsString = strtolower($paramsString);

        // 7) 轉換特定字元(與 dotNet 相符的字元)
        $search = ['%2d', '%5f', '%2e', '%21', '%2a', '%28', '%29'];
        $replace = ['-', '_', '.', '!', '*', '(', ')'];
        $paramsString = str_replace($search, $replace, $paramsString);

        // 8) 進行編碼 (SHA256)
        $paramsString = hash('sha256', $paramsString);

        // 9) 轉為全大寫後回傳
        return strtoupper($paramsString);
    }

    /**
     * 綠界付款結果通知 (Server to Server)
     */
    public function notify(Request $request)
    {
        Log::info('綠界付款通知', $request->all());

        // 驗證檢查碼
        $checkMacValue = $request->input('CheckMacValue');
        $hashKey = 'pwFHCqoQZGmho4w6';
        $hashIV = 'EkRm7iFT261dpevs';

        // 重新計算檢查碼
        $params = (array) $request->except('CheckMacValue');
        $calculatedCheckMacValue = $this->generateCheckMacValue($params, $hashKey, $hashIV);

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

                // 將機車狀態從 pending_checkout 改為 rented
                foreach ($order->orderDetails as $detail) {
                    if ($detail->motorcycle->status === 'pending_checkout') {
                        $detail->motorcycle->update(['status' => 'rented']);
                    }
                }

                Log::info('訂單付款成功', ['order_no' => $orderNo]);
            } else {
                // 付款失敗，恢復機車狀態為可出租
                foreach ($order->orderDetails as $detail) {
                    if ($detail->motorcycle->status === 'pending_checkout') {
                        $detail->motorcycle->update(['status' => 'available']);
                    }
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

        if ($paymentResult === '1') {
            return view('payment.success', compact('order'));
        } else {
            return view('payment.failed', compact('order'));
        }
    }

    /**
     * 付款成功頁面
     */
    public function success(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = null;

        if ($orderId) {
            $order = Order::find($orderId);
        }

        return view('payment.success', compact('order'));
    }
}
