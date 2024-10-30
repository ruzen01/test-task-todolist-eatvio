<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\TodoList;

class TodoListManager extends Component
{
    public $todoLists;
    public $title;
    public $isPublic = 'private';

    protected $rules = [
        'title' => 'required|string|max:255',
        'isPublic' => 'in:private,public',
    ];

    public function mount()
    {
        $this->loadTodoLists();
    }

    public function loadTodoLists()
    {
        $this->todoLists = Auth::user()->todoLists()->get();
    }

    public function createTodoList()
    {
        $this->validate();

        Auth::user()->todoLists()->create(
            [
                'title' => $this->title,
                'is_public' => $this->isPublic === 'public',
            ]
        );

        $this->reset(['title', 'isPublic']);
        $this->loadTodoLists();
    }

    public function deleteTodoList($id)
    {
        $todoList = TodoList::find($id);

        if ($todoList && $todoList->user_id == Auth::id()) {
            $todoList->delete();
            $this->loadTodoLists();
        }
    }

    public function togglePrivacy($id)
    {
        $todoList = TodoList::find($id);

        if ($todoList && $todoList->user_id == Auth::id()) {
            $todoList->is_public = !$todoList->is_public;
            $todoList->save();
            $this->loadTodoLists();
        }
    }

    public function render()
    {
        return view('livewire.todo-list-manager')->layout('layouts.app');
    }
}
