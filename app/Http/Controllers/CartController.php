<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * 顯示購物車
     */
    public function index()
    {
        $cart = Cart::getCurrentCart();
        $cartDetails = $cart->cartDetails()->with('motorcycle')->get();
        
        return view('cart.index', compact('cart', 'cartDetails'));
    }

    /**
     * 添加商品到購物車
     */
    public function add(Request $request, $motorcycleId)
    {
        $request->validate([
            'rent_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:rent_date',
            'quantity' => 'required|integer|min:1|max:10',
            'license_plate' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $motorcycle = Motorcycle::findOrFail($motorcycleId);
        
        if ($motorcycle->status !== 'available') {
            return back()->with('error', '此機車目前無法預約');
        }

        // 更新會員的駕照號碼
        if (auth('member')->check()) {
            $member = auth('member')->user();
            $member->update(['license_plate' => $request->license_plate]);
        }

        $cart = Cart::getCurrentCart();

        // 檢查是否已在購物車中
        $existingItem = $cart->cartDetails()
            ->where('motorcycle_id', $motorcycleId)
            ->where('rent_date', $request->rent_date)
            ->where('return_date', $request->return_date)
            ->first();

        if ($existingItem) {
            // 更新數量
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            // 新增項目
            CartDetail::create([
                'cart_id' => $cart->id,
                'motorcycle_id' => $motorcycleId,
                'quantity' => $request->quantity,
                'rent_date' => $request->rent_date,
                'return_date' => $request->return_date,
                'unit_price' => $motorcycle->price,
                'notes' => $request->notes,
                'license_plate' => $request->license_plate,
            ]);
        }

        return redirect()->route('cart.index')->with('success', '已成功加入購物車！');
    }

    /**
     * 更新購物車項目
     */
    public function update(Request $request, $cartDetailId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartDetail = CartDetail::findOrFail($cartDetailId);
        $cart = Cart::getCurrentCart();

        // 檢查是否為當前用戶的購物車
        if ($cartDetail->cart_id !== $cart->id) {
            return back()->with('error', '無權限操作此項目');
        }

        $cartDetail->update([
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return back()->with('success', '購物車已更新！');
    }

    /**
     * 移除購物車項目
     */
    public function remove($cartDetailId)
    {
        $cartDetail = CartDetail::findOrFail($cartDetailId);
        $cart = Cart::getCurrentCart();

        // 檢查是否為當前用戶的購物車
        if ($cartDetail->cart_id !== $cart->id) {
            return back()->with('error', '無權限操作此項目');
        }

        $cartDetail->delete();

        return back()->with('success', '項目已從購物車移除！');
    }

    /**
     * 清空購物車
     */
    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->clear();

        return back()->with('success', '購物車已清空！');
    }

    /**
     * 前往結帳頁面
     */
    public function checkout()
    {
        $cart = Cart::getCurrentCart();
        
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', '購物車是空的！');
        }

        // 檢查用戶是否已登入
        if (!auth('member')->check()) {
            return redirect()->route('member.login')->with('error', '請先登入才能結帳！');
        }

        $cartDetails = $cart->cartDetails()->with('motorcycle')->get();
        
        return view('cart.checkout', compact('cart', 'cartDetails'));
    }
}
