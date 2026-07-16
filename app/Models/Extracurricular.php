<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo', 'image', 'description'];

    // Membuat slug otomatis dari nama ekskul saat akan disimpan
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($extracurricular) {
            $extracurricular->slug = Str::slug($extracurricular->name);
        });
        static::updating(function ($extracurricular) {
            $extracurricular->slug = Str::slug($extracurricular->name);
        });
    }
}