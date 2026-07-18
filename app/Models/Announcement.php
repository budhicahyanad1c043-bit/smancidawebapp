<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    //
    protected $fillable = ['title', 'slug', 'content', 'type', 'status', 'user_id', 'flyer', 'link_url', 'related_topics',];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
