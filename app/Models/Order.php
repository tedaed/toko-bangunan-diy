<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'phone',
        'payment_method',
        'total_price',
        'status',
        'note'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}