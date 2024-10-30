<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TodoList;
use App\Models\Task;

class TodoListShow extends Component
{
    public $todoList;
    public $tasks;
    public $newTaskTitle;
    public $newTaskVisibility = 'private';
    public $newTaskCompletionStatus = 'canceled';
    public $visibilityOptions = ['public', 'private'];
    public $completionStatusOptions = ['completed', 'canceled'];

    public $editingTaskId = null;
    public $editingTaskTitle;
    public $editingTaskVisibility;
    public $editingTaskCompletionStatus;

    public function mount($id)
    {
        $this->todoList = TodoList::findOrFail($id);
        $this->tasks = $this->todoList->tasks()->get();
    }

    public function addTask()
    {
        $this->validate(
            [
                'newTaskTitle' => 'required|string|max:255',
                'newTaskVisibility' => 'in:public,private',
                'newTaskCompletionStatus' => 'in:completed,canceled'
            ]
        );

        $task = $this->todoList->tasks()->create(
            [
                'title' => $this->newTaskTitle,
                'visibility' => $this->newTaskVisibility,
                'completion_status' => $this->newTaskCompletionStatus,
            ]
        );

        $this->tasks->push($task);
        $this->reset('newTaskTitle', 'newTaskVisibility', 'newTaskCompletionStatus');
    }

    public function editTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->editingTaskId = $taskId;
        $this->editingTaskTitle = $task->title;
        $this->editingTaskVisibility = $task->visibility;
        $this->editingTaskCompletionStatus = $task->completion_status;
    }

    public function updateTask()
    {
        $task = Task::findOrFail($this->editingTaskId);
        $task->update(
            [
                'title' => $this->editingTaskTitle,
                'visibility' => $this->editingTaskVisibility,
                'completion_status' => $this->editingTaskCompletionStatus,
            ]
        );

        $this->tasks = $this->todoList->tasks()->get();
        $this->reset('editingTaskId', 'editingTaskTitle', 'editingTaskVisibility', 'editingTaskCompletionStatus');
    }

    public function deleteTask($taskId)
    {
        Task::findOrFail($taskId)->delete();
        $this->tasks = $this->todoList->tasks()->get();
    }

    public function render()
    {
        return view('livewire.todo-list-show')->layout('layouts.app');
    }
}
