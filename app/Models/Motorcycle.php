<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'model',
        'accessories',
        'license_plate',
        'price',
        'status',
    ];

    protected $casts = [
        'accessories' => 'array',
        'price' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getStatusTextAttribute()
    {
        return $this->status;
    }
}
