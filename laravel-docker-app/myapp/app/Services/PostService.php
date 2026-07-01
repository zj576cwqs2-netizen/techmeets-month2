<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PostService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function createPost(array $data)
    {
        return DB::transaction(function () use ($data) {
            $post = $this->postRepository->create($data);

            if (isset($data['image'])) {
                $this->processImage($post, $data['image']);
            }

            $this->sendNotifications($post);

            Log::info('Post created', ['post_id' => $post->id]);

            return $post;
        });
    }

    public function updatePost(int $id, array $data)
    {
        $post = $this->postRepository->findById($id);

        return DB::transaction(function () use ($post, $data) {
            $updated = $this->postRepository->update($post, $data);

            if (isset($data['image'])) {
                $this->processImage($updated, $data['image']);
            }

            Log::info('Post updated', ['post_id' => $updated->id]);

            return $updated;
        });
    }

    private function processImage(Post $post, UploadedFile $image)
    {
        $path = $image->store('posts');
        $post->update(['image_path' => $path]);
    }

    private function sendNotifications(Post $post)
    {
        Mail::to($post->user)->send(new PostCreated($post));
    }
}
