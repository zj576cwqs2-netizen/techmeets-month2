<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約一覧</title>
</head>
<body>
    <h1>予約一覧</h1>

    <table border="1" cellpadding="8">
        <tr>
            <th>イベント名</th>
            <th>お名前</th>
            <th>メール</th>
            <th>人数</th>
            <th>予約日時</th>
            <th></th>
        </tr>
        @foreach ($reservations as $reservation)
        <tr>
            <td>{{ $reservation->event->title }}</td>
            <td>{{ $reservation->name }}</td>
            <td>{{ $reservation->email }}</td>
            <td>{{ $reservation->number_of_people }}人</td>
            <td>{{ $reservation->reserved_at->format('Y/m/d H:i') }}</td>
            <td>
                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('キャンセルしますか?')">キャンセル</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>