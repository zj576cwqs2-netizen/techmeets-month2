<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イベント一覧</title>
</head>
<body>
    <h1>イベント一覧</h1>

    <table border="1" cellpadding="8">
        <tr>
            <th>イベント名</th>
            <th>開催日時</th>
            <th>場所</th>
            <th></th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->title }}</td>
            <td>{{ $event->event_date->format('Y/m/d H:i') }}</td>
            <td>{{ $event->location }}</td>
            <td><a href="{{ route('events.show', $event) }}">詳細</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
