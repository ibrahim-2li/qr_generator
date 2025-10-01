<?php

namespace App\Models;

use App\Models\QrCode;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    public $timestamps = false;
    protected $fillable = ['qr_code_id','ip','country','device','os','scanned_at'];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
