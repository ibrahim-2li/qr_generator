<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scan extends Model
{
    use HasFactory;
    protected $fillable = ['qr_code_id', 'ip', 'country', 'region', 'city', 'device', 'os'];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
