<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - My App</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <header>
        <nav>
            <a href="/">ホーム</a>
            <a href="/posts">投稿一覧</a>
        </nav>
    </header>

    <main>
       @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

{{-- old('title'): バリデーション失敗後に以前の入力値を再表示する --}}
<input type="text" name="title" value="{{ old('title') }}">

{{-- @error: 特定のフィールドにエラーがある場合だけ表示 --}}
@error('title')
    <span>{{ $message }}</span>
@enderror
</body>
</html>