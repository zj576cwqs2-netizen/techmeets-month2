<?php

namespace App\Http\Controllers;

use App\Modela\Controllers;
use Illuminate\Http\Request;

class Postcontroller extends controllers
{
public function index()
{
     $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
}

public function store(Request $request)
{
$validated = $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
        ]);
$post = Post::create($validated);
return redirect()->route('posts.show', $post)->with('success', '投稿を作成しました');
// show / edit / update も同じパターン（findOrFail → view or redirect）

 public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', '投稿を削除しました');
    }
}