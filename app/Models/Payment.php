<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['subscription_id', 'payment_id', 'amount', 'status', 'payload'];

    protected $casts = [
        'payload' => 'array',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
