<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo', 'principal_photo', 'school_name', 'principal_name', 
        'vision', 'email', 'phone', 'address', 'website'
    ];
}