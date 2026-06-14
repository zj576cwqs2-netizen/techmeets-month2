<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約フォーム</title>
</head>
<body>
    <h1>{{ $event->title }} の予約</h1>

    <form action="{{ route('reservations.store', $event) }}" method="POST">
        @csrf

        <p>
            <label>お名前</label><br>
            <input type="text" name="name">
        </p>

        <p>
            <label>メールアドレス</label><br>
            <input type="email" name="email">
        </p>

        <p>
            <label>人数</label><br>
            <input type="number" name="number_of_people" min="1" value="1">
        </p>

        <p>
            <label>予約日時</label><br>
            <input type="datetime-local" name="reserved_at">
        </p>

        <button type="submit">予約する</button>
    </form>

    <a href="{{ route('events.show', $event) }}">戻る</a>
</body>
</html>