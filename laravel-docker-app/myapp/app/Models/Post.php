<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];
protected $casts = [
    'created_at' => 'datetime',

];

//belongsTo:　投稿(多) →　ユーザー(1)
public function user()
{
    return $this->belongsTo(User::class);
}
    }
