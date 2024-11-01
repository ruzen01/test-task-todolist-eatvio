<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TodoList;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoListPolicy
{
    use HandlesAuthorization;

    // Разрешить просмотр публичных списков всем, включая гостей
    public function view(?User $user, TodoList $todoList)
    {
        return $todoList->is_public || ($user && $user->id === $todoList->user_id);
    }

    // Только владелец может обновлять список
    public function update(User $user, TodoList $todoList)
    {
        return $user->id === $todoList->user_id;
    }

    // Только владелец может удалять список
    public function delete(User $user, TodoList $todoList)
    {
        return $user->id === $todoList->user_id;
    }

    // Только владелец может менять приватность списка
    public function togglePrivacy(User $user, TodoList $todoList)
    {
        return $user->id === $todoList->user_id;
    }
}
