<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthorizesRequests;

    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = Post::where('published', true)->get();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $post = Post::create($request->only('title', 'body'));
        $post->tags()->sync($request->tags);

        return redirect()->route('posts.index');
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        $post->update($validated);
        $post->tags()->sync($request->tags ?? []);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', '投稿を更新しました');
    }

    public function show(int $id)
    {
        $post = Post::findOrFail($id);
        $tags = $post->tags; 

        return view('posts.show', compact('post', 'tags'));
    }
}
