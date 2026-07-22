<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'route_name',
        'icon',
        'parent_id',
        'location',
        'order',
        'is_active',
        'permission_role',
    ];

    // Relasi ke Submenu (Anak Menu)
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order', 'asc');
    }

    // Relasi ke Parent Menu (Induk)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Helper untuk mengecek apakah URL/Route sedang aktif
    public function isActiveRoute()
    {
        if ($this->route_name && request()->routeIs($this->route_name)) {
            return true;
        }
        if ($this->url && request()->is(ltrim($this->url, '/'))) {
            return true;
        }
        return false;
    }
}