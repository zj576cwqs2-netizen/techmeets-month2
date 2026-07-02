<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク新規作成</title>
</head>
<body>
    <h1>タスク新規作成</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div>
            <label>タイトル</label><br>
            <input type="text" name="title" required maxlength="200">
        </div>
        <div>
            <label>内容</label><br>
            <textarea name="description" required></textarea>
        </div>
        <button type="submit">作成する</button>
    </form>
    <p><a href="{{ route('tasks.index') }}">一覧に戻る</a></p>
</body>
</html>