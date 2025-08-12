<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorcycleAccessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'quantity',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function getStatusTextAttribute()
    {
        return [
            '待出租' => '待出租',
            '出租中' => '出租中',
            '停用' => '停用',
        ][$this->status] ?? $this->status;
    }
}
