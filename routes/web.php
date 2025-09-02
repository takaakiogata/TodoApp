<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

// タスク一覧ページ（ログイン済みのみ）
Route::middleware(['auth', 'verified'])->group(function () {

    // Breeze のログイン後リダイレクト先
    Route::get('/dashboard', function () {
        return redirect()->route('top');
    })->name('dashboard');

    // タスク一覧表示
    Route::get('/top', [TaskController::class, 'index'])->name('top');

    // タスク新規登録
    Route::post('/top', [TaskController::class, 'store'])->name('task.store');

    // 編集画面表示（タスク＋タグ）
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');

    // 更新処理（タスク＋タグ）
    Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');

    // 削除処理
    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
