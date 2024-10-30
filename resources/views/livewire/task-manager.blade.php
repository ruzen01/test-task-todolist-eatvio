<div>
    <h3>Задачи для списка {{ $todoListId }}</h3>

    <input type="text" wire:model="description" placeholder="Описание задачи">
    <label>
        <input type="checkbox" wire:model="isPublic"> Публичная
    </label>
    <select wire:model="status">
        <option value="private">Приватная</option>
        <option value="public">Публичная</option>
        <option value="completed">Завершена</option>
        <option value="cancelled">Отменена</option>
    </select>
    <button wire:click="createTask">Добавить задачу</button>

    <ul>
        @foreach ($tasks as $task)
            <li>
                {{ $task->description }} ({{ $task->status }})
                <button wire:click="deleteTask({{ $task->id }})">Удалить</button>
            </li>
        @endforeach
    </ul>
</div>