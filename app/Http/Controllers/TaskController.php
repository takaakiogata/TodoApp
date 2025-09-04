<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;

class TaskController extends Controller
{
    // 一覧表示 + 検索
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Task::with('tags')->where('status', false);

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhereHas('tags', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
        }

        $tasks = $query->get();
        return view('top', compact('tasks', 'keyword'));
    }


    // タスクの完了判定
    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['status' => true]);
        return redirect()->route('top');
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

        return redirect()->route('top');
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

        return redirect()->route('top');
    }

    // 削除処理
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->tags()->detach(); 
        $task->delete();

        return redirect()->route('top');
    }
}
