<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // app/Models/Tag.php
public function posts()
{
    return $this->belongsToMany(Post::class);
}
}