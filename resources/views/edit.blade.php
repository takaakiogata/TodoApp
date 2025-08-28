<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク編集</title>
</head>
<body>
    <h1>タスク編集</h1>

    <form action="{{ route('todo.update', $todo->id) }}" method="POST">
        @csrf
        <p>
            <input type="text" name="task" value="{{ old('task', $todo->task) }}">
        </p>
        <p>
            <input type="text" name="tag1" value="{{ old('tag1', $todo->tag1) }}">
            <input type="text" name="tag2" value="{{ old('tag2', $todo->tag2) }}">
            <input type="text" name="tag3" value="{{ old('tag3', $todo->tag3) }}">
        </p>
        <p>
            <input type="submit" value="更新">
        </p>
    </form>

    <p><a href="{{ route('dashboard') }}">戻る</a></p>
</body>
</html>
