<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrUrl extends Model
{
    protected $fillable = ['qr_code_id', 'name', 'url'];

    public function qrcode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
