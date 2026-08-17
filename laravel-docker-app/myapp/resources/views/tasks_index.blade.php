<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク一覧</title>
</head>
<body>
    <h1>タスク一覧</h1>
    @foreach($tasks as $task)
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <strong>{{ $task->title }}</strong>
        <p>{{ $task->description }}</p>
        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" onsubmit="return confirm('本当に削除しますか?');">
            @csrf
            @method('DELETE')
            <button type="submit">削除</button>
        </form>
    </div>
@endforeach
    {{ $tasks->links() }}

</body>
</html>