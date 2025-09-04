<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Todo APP
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- タスク作成フォーム -->
                    <form action="{{ route('task.store') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="text" name="name" placeholder="タスクを入力"
                                class="border rounded px-2 py-1 w-full sm:w-auto">

                            <input type="text" name="tags[]" placeholder="タグ1"
                                class="border rounded px-2 py-1 w-full sm:w-auto">
                            <input type="text" name="tags[]" placeholder="タグ2"
                                class="border rounded px-2 py-1 w-full sm:w-auto">
                            <input type="text" name="tags[]" placeholder="タグ3"
                                class="border rounded px-2 py-1 w-full sm:w-auto">

                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                作成
                            </button>
                        </div>
                    </form>

                    <!-- 検索フォーム -->
                    <form action="{{ route('top') }}" method="GET" class="mb-6">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="text" name="keyword" placeholder="タスク名,タグ名で検索"
                                value="{{ $keyword ?? '' }}"
                                class="border rounded px-2 py-1 w-full sm:w-auto">

                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                検索
                            </button>
                        </div>
                    </form>

                    <!-- タスク一覧 -->
                    <ul class="space-y-3">
                        @foreach($tasks as $task)
                            @unless($task->status)
                            <li class="flex items-center justify-between border-b pb-2">
                                <div>
                                    <span class="font-medium">{{ $task->name }}</span>
                                    <span class="text-sm text-gray-500">
                                        ( @foreach($task->tags as $tag) {{ $tag->name }} @endforeach )
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <!-- 完了ボタン -->
                                    <form action="{{ route('task.complete', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:underline">完了</button>
                                    </form>

                                    <a href="{{ route('task.edit', $task->id) }}"
                                        class="text-blue-600 hover:underline">編集</a>

                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST"
                                        onsubmit="return confirm('削除してもよろしいですか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">削除</button>
                                    </form>
                                </div>
                            </li>
                            @endunless
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
