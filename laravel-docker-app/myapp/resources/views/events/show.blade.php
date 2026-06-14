<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イベント詳細</title>
</head>
<body>
    <h1>{{ $event->title }}</h1>

    <p>開催日時: {{ $event->event_date->format('Y/m/d H:i') }}</p>
    <p>場所: {{ $event->location }}</p>
    <p>定員: {{ $event->capacity }}人</p>
    <p>説明: {{ $event->description }}</p>

    <a href="{{ route('reservations.create', $event) }}">このイベントを予約する</a>
    <br>
    <a href="{{ route('events.index') }}">一覧に戻る</a>
</body>
</html>