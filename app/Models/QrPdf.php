<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrPdf extends Model
{
    protected $fillable = ['name', 'description', 'file', 'color_l', 'color_d'];

    public function qrcode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
