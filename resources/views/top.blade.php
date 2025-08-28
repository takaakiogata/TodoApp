<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <title>ToDoリスト</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    <h1>Todo APP</h1>
    <form action="{{ route('todo.store') }}" method="POST">
        @csrf
        <p>
            <input type="text" name="task" placeholder="タスクを入力">
        </p>
        <p>
            <input type="text" name="tag1" placeholder="タグ1">
            <input type="text" name="tag2" placeholder="タグ2">
            <input type="text" name="tag3" placeholder="タグ3">
        </p>
        <p>
            <input type="submit" value="作成">
        </p>
    </form>


    <form action="" method="POST">
        @csrf
        <input type="text" name="word">
        <p>
            <input type="submit" value="検索">
        </p>
    </form>

    <h2>タスク一覧</h2>
    <ul>
        @foreach($todos as $todo)
        <li>
            {{ $todo->task }}
            ( {{ $todo->tag1 }} {{ $todo->tag2 }} {{ $todo->tag3 }} )

            <!-- 編集ボタン -->
            <button type="submit"><a href="{{ route('todo.edit', $todo->id) }}">編集</a></button>
            

            <!-- 削除ボタン -->
            <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
        </li>
        @endforeach
    </ul>


</body>

</html>