<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UserSettings;
use App\Livewire\TodoListManager;
use App\Livewire\TaskManager;
use App\Livewire\TodoListShow;

Route::middleware(['auth'])->group(
    function () {
        Route::get('/todo-lists', TodoListManager::class)->name('todo-list.index');
        Route::get('/todo-list/{id}', TodoListShow::class)->name('todo-list.show');
        Route::get('/todo-lists/{todoList}/tasks', TaskManager::class)->name('todo.tasks');
    }
);

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
