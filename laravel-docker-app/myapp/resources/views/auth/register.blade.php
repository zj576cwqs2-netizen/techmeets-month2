<!DOCTYPE html>
<html>
<head>
    <title>会員登録</title>
</head>
<body>
    <h1>会員登録</h1>

    @if ($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div>
            <label>お名前</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            <label>パスワード</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>パスワード(確認)</label>
            <input type="password" name="password_confirmation">
        </div>
        <button type="submit">登録する</button>
    </form>
</body>
</html>
