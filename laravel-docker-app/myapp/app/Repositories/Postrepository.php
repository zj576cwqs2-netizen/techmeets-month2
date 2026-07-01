<?php

namespace App\Repositories;

use App\Models\Post;

class Postrepository
{
    public function getAll()
    {
        return Post::latest()->paginate(10);
    }


    public function findById(int $id)
    {
        return Post::findOrFail($id);
    }

    public function getPublisged()
    {
        return Post::where ('status', 'published')
        ->latest()
        ->paginate(10);
    }
    

    public function getByuser(int $userId)
    {
        return Post::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post)
    {
        return $post->delete();
    }
}