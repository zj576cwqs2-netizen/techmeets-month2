<?php
namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private PostService $postService
    ) {}

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = $this->postService->createPost($validated);
        $this->postService->syncTags($post, $request->tags ?? []);

        return redirect()->route('posts.index');
    }

    public function update(Request $request, int $id)
    {
        $post = $this->postService->getPostById($id);
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        $updated = $this->postService->updatePost($id, $validated);
        $this->postService->syncTags($updated, $request->tags ?? []);

        return redirect()
            ->route('posts.show', $updated)
            ->with('success', '投稿を更新しました');
    }

    public function show(int $id)
    {
        $post = $this->postService->getPostById($id);
        return view('posts.show', ['post' => $post, 'tags' => $post->tags]);
    }
}
   