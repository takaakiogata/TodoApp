<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;

class TaskController extends Controller
{
    // 一覧表示
    public function index()
    {
        $tasks = Task::with('tags')->get();
        return view('top', compact('tasks'));
    }

    // 新規登録
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'tags' => 'array|max:3',
            'tags.*' => 'nullable|string|max:50'
        ]);

        // タスク作成
        $task = Task::create(['name' => $request->name]);

        // タグ処理
        $tagIds = [];
        if ($request->tags) {
            foreach ($request->tags as $tagName) {
                if (!$tagName) continue;
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
        }
        $task->tags()->sync($tagIds);

        return redirect()->route('top')->with('success', 'タスクを追加しました');
    }

    // 編集画面表示
    public function edit($id)
    {
        $task = Task::with('tags')->findOrFail($id);
        return view('edit', compact('task'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'tags' => 'array|max:3',
            'tags.*' => 'nullable|string|max:50'
        ]);

        $task = Task::findOrFail($id);

        // タスク名の更新
        $task->update([
            'name' => $request->name,
        ]);

        // タグの更新
        $tagIds = [];
        if ($request->tags) {
            foreach ($request->tags as $tagName) {
                if (!$tagName) continue;
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
        }
        $task->tags()->sync($tagIds);

        return redirect()->route('top')->with('success', 'タスクを更新しました');
    }

    // 削除処理
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->tags()->detach(); // 中間テーブルの紐付けも削除
        $task->delete();

        return redirect()->route('top')->with('success', 'タスクを削除しました');
    }
}
