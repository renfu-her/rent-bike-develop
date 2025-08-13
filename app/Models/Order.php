<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'member_id',
        'total_price',
        'rent_date',
        'return_date',
        'is_completed',
        'order_no',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'rent_date' => 'date',
        'return_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * 生成訂單編號
     * 格式：RENT-年月日+4碼流水號
     * 隔日重新從0001開始
     */
    public static function generateOrderNo()
    {
        $today = now()->format('Ymd');
        $prefix = "RENT-{$today}-";
        
        // 取得今日最後一個訂單編號
        $lastOrder = self::where('order_no', 'like', $prefix . '%')
            ->orderBy('order_no', 'desc')
            ->first();
        
        if ($lastOrder) {
            // 提取流水號並加1
            $lastSequence = (int) substr($lastOrder->order_no, -4);
            $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // 今日第一個訂單
            $newSequence = '0001';
        }
        
        return $prefix . $newSequence;
    }
}
