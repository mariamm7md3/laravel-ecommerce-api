<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    protected $table = 'app_info';

    protected $fillable = [
        'phone',
        'email',
        'address',
        'facebook_link',
        'instagram_link',
        'whatsapp_link',
        'twitter_link',
    ];
}
