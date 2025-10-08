<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrContent extends Model
{
    protected $fillable = ['qr_code_id', 'color_l', 'color_d', 'profile_photo_path', 'name', 'phone', 'email', 'company', 'linkedin', 'snap', 'x', 'facebook', 'instagram', 'youtube'];

    public function qrcode()
    {
        return $this->belongsTo(QrCode::class, 'qr_code_id', 'id');
    }

    /**
     * Get the URL to the profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path && file_exists(storage_path('app/public/'.$this->profile_photo_path))) {
            return asset('storage/'.$this->profile_photo_path);
        }

        return $this->defaultProfilePhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }
}
