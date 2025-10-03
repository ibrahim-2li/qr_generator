<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = ['qr_code_id', 'ip', 'country', 'region', 'city', 'device', 'os'];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
