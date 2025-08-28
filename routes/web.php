<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});



Route::post('/todo/store', [TodoController::class, 'store'])->name('todo.store');

Route::get('/dashboard', function () {
    return view('top');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [TodoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 編集用ルート
Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
Route::post('/todo/{id}/update', [TodoController::class, 'update'])->name('todo.update');

// 削除用ルート
Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
