<div> 
    <h2>{{ $todoList->title }}</h2> 
    <p>Статус: {{ $todoList->is_public ? 'Публичный' : 'Приватный' }}</p> 

    <h4>Задачи</h4> 

    <input type="text" wire:model="newTaskTitle" placeholder="Название новой задачи"> 

    <select wire:model="newTaskVisibility"> 
        @foreach ($visibilityOptions as $option) 
            <option value="{{ $option }}">{{ ucfirst($option) }}</option> 
        @endforeach 
    </select> 

    <select wire:model="newTaskCompletionStatus"> 
        @foreach ($completionStatusOptions as $option) 
            <option value="{{ $option }}">{{ ucfirst($option) }}</option> 
        @endforeach 
    </select> 

    <button wire:click="addTask">Добавить задачу</button> 

    <ul> 
        @foreach ($tasks as $task) 
            <li> 
                @if ($editingTaskId === $task->id) 
                    <input type="text" wire:model="editingTaskTitle"> 

                    <select wire:model="editingTaskVisibility"> 
                        @foreach ($visibilityOptions as $option) 
                            <option value="{{ $option }}">{{ ucfirst($option) }}</option> 
                        @endforeach 
                    </select> 

                    <select wire:model="editingTaskCompletionStatus"> 
                        @foreach ($completionStatusOptions as $option) 
                            <option value="{{ $option }}">{{ ucfirst($option) }}</option> 
                        @endforeach 
                    </select> 

                    <button wire:click="updateTask">Сохранить</button> 
                    <button wire:click="$set('editingTaskId', null)">Отмена</button> 
                @else 
                    {{ $task->title }} - Видимость: {{ $task->visibility }} - Статус: {{ $task->completion_status }} 
                    <button wire:click="editTask({{ $task->id }})">Редактировать</button> 
                    <button wire:click="deleteTask({{ $task->id }})">Удалить</button> 
                @endif 
            </li> 
        @endforeach 

    </ul> 
</div>