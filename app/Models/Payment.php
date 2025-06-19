<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'payment_type',
        'payment_id',
        'external_id',
        'amount',
        'status',
        'payment_url',
        'guest_token',
        'webhook_data',
        'transaction_id',
        'name',
        'email',
        'phone',
        'address',
        'cash_delivery',
        'total_amount',
        'invoice_no',
        'order_date',
        'order_month',
        'order_year',
    ];

    protected $casts = [
        'webhook_data' => 'json',
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'payment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
