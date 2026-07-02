<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PostCreated;

class PostService
{
 
    public function __construct(
        private PostRepository $postRepository
    ) {}

    public function createPost(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. 投稿作成
            $post = $this->postRepository->create($data);

            // 2. 画像処理
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

    private function processImage(
        \Illuminate\Database\Eloquent\Model $post,
        UploadedFile $image
    )
    {
        $path = $image->store('posts');
        $post->update(['image_path' => $path]);
    }

    private function sendNotifications(Model $post)
    {
        Mail::to($post->user)->send(new PostCreated());
    }
}