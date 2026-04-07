<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'interval', 'is_active', 'features'];

    protected $casts = [
        'interval' => 'integer',
        'price' => 'integer',
        'is_active' => 'boolean',
        'features' => 'array',

    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
