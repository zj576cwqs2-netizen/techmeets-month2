<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク詳細</title>
</head>
<body>
    <h1>{{ $task->title }}</h1>
    <p>{{ $task->description }}</p>
    <p><a href="{{ route('tasks.index') }}">一覧に戻る</a></p>
</body>
</html>