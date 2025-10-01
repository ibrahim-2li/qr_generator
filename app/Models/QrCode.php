<?php

namespace App\Models;

use App\Models\Scan;
use App\Models\User;
use App\Models\QrContent;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $fillable = ['user_id','type','data','is_dynamic','slug','scan_count'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function content()
    {
        return $this->hasOne(QrContent::class);
    }
}
