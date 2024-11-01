<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    // Разрешение на создание задачи в списке
    public function create(User $user, Task $task)
    {
        // Позволяем создавать задачи только владельцам списка
        return $user->id === $task->todoList->user_id;
    }

    // Разрешить просмотр публичных задач всем, включая гостей
    public function view(?User $user, Task $task)
    {
        // Публичные задачи видны всем, приватные - только владельцу задачи
        return $task->is_public || ($user && $user->id === $task->user_id);
    }

    // Только владелец задачи может обновлять
    public function update(User $user, Task $task)
    {
        return $user->id === $task->todoList->user_id;
    }

    // Только владелец задачи может удалять
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->todoList->user_id;
    }
}