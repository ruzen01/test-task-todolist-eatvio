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

    public $isEditingList = false;
    public $editingListId = null;
    public $editingListTitle = '';
    public $editingListVisibility = 'private';

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
        if (Auth::check()) {
            // Для авторизованных пользователей показываем их списки (все) + публичные списки других пользователей
            $this->todoLists = TodoList::where('user_id', Auth::id())
                                       ->orWhere('is_public', true)
                                       ->get();
        } else {
            // Для неавторизованных пользователей показываем только публичные списки
            $this->todoLists = TodoList::where('is_public', true)
                                        ->get();
        }
    }
    

    public function createTodoList()
    {
        $this->validate();

        Auth::user()->todoLists()->create([
            'title' => $this->title,
            'is_public' => $this->isPublic === 'public',
        ]);

        $this->reset(['title', 'isPublic']);
        $this->loadTodoLists();
    }

    public function deleteTodoList($id)
    {
        $todoList = TodoList::findOrFail($id);
        $this->authorize('delete', $todoList);

        $todoList->delete();
        $this->loadTodoLists();
    }

    public function togglePrivacy($id)
    {
        $todoList = TodoList::findOrFail($id);
        $this->authorize('togglePrivacy', $todoList);

        $todoList->is_public = !$todoList->is_public;
        $todoList->save();
        $this->loadTodoLists();
    }

    public function render()
    {
        return view('livewire.todo-list-manager')->layout('layouts.app');
    }

    public function editTodoList($id, $title, $visibility)
    {
        $this->editingListId = $id;
        $this->editingListTitle = $title;
        $this->editingListVisibility = $visibility;
    }

    public function updateTodoList()
    {
        $list = TodoList::findOrFail($this->editingListId);

        $list->update([
            'title' => $this->editingListTitle,
            'is_public' => $this->editingListVisibility === 'public',
        ]);

        $this->todoLists = TodoList::where(function ($query) {
            $query->where('user_id', auth()->id())
                  ->orWhere('is_public', true);
        })->get();

        $this->reset('editingListId', 'editingListTitle', 'editingListVisibility');
    }
}
