<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    <h1>新規登録</h1>
    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>名前: <input type="text" name="name" required></label><br>
        <label>メール: <input type="email" name="email" required></label><br>
        <label>パスワード: <input type="password" name="password" required></label><br>
        <label>確認: <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">登録</button>
    </form>
    <a href="{{ route('login') }}">ログインはこちら</a>
</body>
</html>
