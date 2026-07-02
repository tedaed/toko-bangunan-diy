<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'customer_name',
        'phone',
        'payment_method',
        'total_price',
        'status',
        'status_note',
        'stock_reduced_at',
        'note',
        'dp_amount',
        'payment_proof',
        'payment_status',
        'dp_expired_at',
    ];
    protected $casts = [
        'stock_reduced_at' => 'datetime',
        'dp_expired_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
