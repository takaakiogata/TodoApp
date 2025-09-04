<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('task.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- タスク名 -->
                    <div class="mb-3">
                        <label for="name" class="form-label">タスク名</label>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $task->name) }}"
                            class="form-control" required>
                    </div>

                    <!-- タグ -->
                    <div class="mb-3">
                        <label class="form-label"></label>
                        <div id="tag-inputs">
                            @for ($i = 0; $i < 3; $i++)
                                <input type="text" name="tags[]" 
                                    value="{{ old('tags.' . $i, $task->tags[$i]->name ?? '') }}" 
                                    placeholder="タグを入力"
                                    class="form-control mb-2">
                            @endfor
                        </div>
                    </div>

                    <!-- 更新ボタン -->
                    <button type="submit" class="btn btn-primary">更新</button>
                    <a href="{{ route('top') }}" class="btn btn-secondary">キャンセル</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
