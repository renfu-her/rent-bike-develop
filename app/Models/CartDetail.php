<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'motorcycle_id',
        'quantity',
        'rent_date',
        'return_date',
        'unit_price',
        'subtotal',
        'notes',
        'license_plate',
    ];

    protected $casts = [
        'rent_date' => 'date',
        'return_date' => 'date',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }

    /**
     * 計算小計
     */
    public function calculateSubtotal()
    {
        $days = $this->rent_date->diffInDays($this->return_date) + 1;
        $this->subtotal = $this->unit_price * $days; // 數量固定為 1
        return $this->subtotal;
    }

    /**
     * 儲存前自動計算小計
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($cartDetail) {
            $cartDetail->calculateSubtotal();
        });

        static::saved(function ($cartDetail) {
            $cartDetail->cart->updateTotalAmount();
        });

        static::deleted(function ($cartDetail) {
            $cartDetail->cart->updateTotalAmount();
        });
    }
}
