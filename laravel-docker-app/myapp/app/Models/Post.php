<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\User;

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
// PostController.php
public function show(int $id)
{
    $post = Post::find($id);
    $tags = $post->tags; // タグ一覧を取得

    return view('posts.show', compact('post', 'tags'));
}
}
