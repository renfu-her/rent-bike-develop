<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'session_id',
        'total_amount',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }

    /**
     * 取得或創建當前用戶的購物車
     */
    public static function getCurrentCart()
    {
        $member = auth('member')->user();
        
        if ($member) {
            // 已登入用戶
            $cart = self::where('member_id', $member->id)
                ->where('status', 'active')
                ->first();
        } else {
            // 未登入用戶，使用 session
            $sessionId = Session::getId();
            $cart = self::where('session_id', $sessionId)
                ->where('status', 'active')
                ->first();
        }

        if (!$cart) {
            $cart = self::create([
                'member_id' => $member ? $member->id : null,
                'session_id' => $member ? null : Session::getId(),
                'total_amount' => 0,
                'status' => 'active',
                'expires_at' => now()->addDays(7), // 7天後過期
            ]);
        }

        return $cart;
    }

    /**
     * 更新購物車總金額
     */
    public function updateTotalAmount()
    {
        $total = $this->cartDetails()->sum('subtotal');
        $this->update(['total_amount' => $total]);
        return $this;
    }

    /**
     * 清空購物車
     */
    public function clear()
    {
        $this->cartDetails()->delete();
        $this->update(['total_amount' => 0]);
        return $this;
    }

    /**
     * 檢查購物車是否為空
     */
    public function isEmpty()
    {
        return $this->cartDetails()->count() === 0;
    }

    /**
     * 取得購物車項目數量
     */
    public function getItemCount()
    {
        return $this->cartDetails()->sum('quantity');
    }
}
