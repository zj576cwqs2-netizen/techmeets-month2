<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>
    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>メール: <input type="email" name="email" required></label><br>
        <label>パスワード: <input type="password" name="password" required></label><br>
        <button type="submit">ログイン</button>
    </form>
</body>
</html>