<html lang="ja">
<head><meta charset="UTF-8"><title>ダッシュボード</title></head>
<body>
    <h1>ダッシュボード</h1>
    <p>ログイン中: {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
    <a href="{{ route('posts.index') }}">掲示板へ</a>
</body>
</html>
