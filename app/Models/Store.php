<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function motorcycles()
    {
        return $this->hasMany(Motorcycle::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getStatusTextAttribute()
    {
        return $this->status;
    }
}
