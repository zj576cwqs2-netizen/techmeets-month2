<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
</head>
<body>
    <h1>掲示板</h1>

    @auth
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <textarea name="content" placeholder="投稿内容" required></textarea><br>
            <button type="submit">投稿する</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">ログインして投稿する</a></p>
    @endauth

    @foreach($posts as $post)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <strong>名無しさん</strong>
            <span>{{ $post->created_at->format('Y/m/d H:i') }}</span>
            <p>{{ $post->content }}</p>
            @auth
                @if(auth()->id() === $post->user_id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach

    {{ $posts->links() }}
</body>
</html>
