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
        $this->tasks = Task::where('todo_list_id', $this->todoListId)->get();
    }

    public function createTask()
    {
        $this->validate();

        Task::create(
            [
            'todo_list_id' => $this->todoListId,
            'description' => $this->description,
            'is_public' => $this->isPublic,
            'status' => $this->status,
            ]
        );

        $this->reset(['description', 'isPublic', 'status']);
        $this->loadTasks();
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        if ($task && $task->todo_list_id == $this->todoListId) {
            $task->delete();
            $this->loadTasks();
        }
    }

    public function render()
    {
        return view('livewire.task-manager')->layout('layouts.app');
    }
}