//Create: 作成
$post = Post::create(Request $request)
{
    $validated = $request->validate([
        'title'   => 'required|max:200',
        'content' => 'required',
    ]);

    Post::create($validated);
    return redirect()->route('posts.index');
}

//READ: 読み取り
$posts = Post::all();
$posts = Post::where('user_id', 1)->get();  // 条件付き
$post  = Post::findOrFail(1);               // IDで1件（なければ404）
$posts = Post::latest()->paginate(10);      // 新しい順・ページネーション

//Update: 更新
$post->update(Request $request, Post $post)
{
    $validated = $request->validate([
        'title'   => 'required|max:200',
        'content' => 'required',
    ]);

    $post->update($validated);
    return redirect()->route('posts.index');
}

Delete: 削除
$post->delete();
