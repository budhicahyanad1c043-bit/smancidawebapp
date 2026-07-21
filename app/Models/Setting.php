<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo', 'principal_photo', 'school_name', 'principal_name', 
        'vision', 'email', 'phone', 'address', 'website', 'welcome_message', 'facebook_url', 'instagram_url', 'youtube_url', 'description_school', 'npsn', 'is_maintenance',
    ];
}