<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    // 一覧表示
    public function index()
    {
        $todos = Todo::all();
        return view('top', compact('todos'));
    }

    // 新規登録
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:100',
            'tag1' => 'nullable|string|max:20',
            'tag2' => 'nullable|string|max:20',
            'tag3' => 'nullable|string|max:20',
        ]);

        Todo::create($request->only(['task','tag1','tag2','tag3']));

        return redirect()->route('dashboard')->with('success', 'タスクを追加しました！');
    }

    // 編集画面表示
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('edit', compact('todo'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required|string|max:100',
            'tag1' => 'nullable|string|max:20',
            'tag2' => 'nullable|string|max:20',
            'tag3' => 'nullable|string|max:20',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update($request->only(['task','tag1','tag2','tag3']));

        return redirect()->route('dashboard')->with('success', 'タスクを更新しました！');
    }

    // 削除処理
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->route('dashboard')->with('success', 'タスクを削除しました！');
    }
}
