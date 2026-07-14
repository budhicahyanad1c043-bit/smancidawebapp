<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id',
        'category_id'
    ];

    // Relasi balik ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Otomatis membuat slug unik dari judul sebelum disimpan
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title) . '-' . time();
        });
    }

    // Relasi ke User (Penulis)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}