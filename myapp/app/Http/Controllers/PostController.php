<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('posts.index', now()->addMinutes(10), function () {
            return Post::with('user')->get();
        });

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // WebPに変換
        $manager = new ImageManager(new Driver());
        $file = $request->file('image');

        if (method_exists($manager, 'read')) {
            $image = $manager->read($file->getRealPath())->toWebp(80);
        } elseif (method_exists($manager, 'make')) {
            $image = $manager->make($file->getRealPath())->encode('webp', 80);
        } else {
            throw new \RuntimeException('Image library does not support WebP conversion.');
        }

        $filename = 'images/' . uniqid() . '.webp';

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('s3');
        $disk->put($filename, (string) $image);

        $url = $disk->url($filename);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->image_url = $url;
        $post->user_id = Auth::id();
        $post->save();

        Cache::forget('posts.index');

        return redirect('/posts');
    }
}
