<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskManager extends Component
{
    public $todoListId;
    public $tasks;
    public $description;
    public $isPublic = false;
    public $status = 'private';

    protected $rules = [
        'description' => 'required|string|max:255',
        'isPublic' => 'boolean',
        'status' => 'in:private,public,completed,cancelled'
    ];

    public function mount($todoListId)
    {
        $this->todoListId = $todoListId;
        $this->loadTasks();
    }

    public function loadTasks()
    {
        if (Auth::check()) {
            // Загружаем задачи текущего пользователя и публичные задачи других пользователей
            $this->tasks = Task::where('todo_list_id', $this->todoListId)
                ->where(function ($query) {
                    $query->where('is_public', true)
                          ->orWhere('user_id', Auth::id());
                })
                ->get();
        } else {
            // Для гостей загружаем только публичные задачи
            $this->tasks = Task::where('todo_list_id', $this->todoListId)
                ->where('is_public', true)
                ->get();
        }
    }

    public function createTask()
    {
        // Создаем временный экземпляр задачи для проверки политики
        $task = new Task([
            'todo_list_id' => $this->todoListId,
            'user_id' => auth()->id(),
        ]);
    
        // Авторизация на основе политики
        $this->authorize('create', $task);
    
        $this->validate();
    
        Task::create(
            [
                'todo_list_id' => $this->todoListId,
                'description' => $this->description,
                'is_public' => $this->isPublic,
                'status' => $this->status,
                'user_id' => auth()->id(), // Добавляем ID текущего пользователя
            ]
        );
    
        $this->reset(['description', 'isPublic', 'status']);
        $this->loadTasks();
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);

        $task->delete();
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.task-manager')->layout('layouts.app');
    }
}
