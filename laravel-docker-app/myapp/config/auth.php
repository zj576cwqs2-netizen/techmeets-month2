@auth
    <p>ログインしています: {{ auth()->user()->name }}</p>
@else
    <p>ログインしていません</p>
@endauth

@guest
    <a href="{{ route('login') }}">ログイン</a>
@endguest