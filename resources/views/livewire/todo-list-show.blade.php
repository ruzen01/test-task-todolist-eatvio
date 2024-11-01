<div>     
    <h2>{{ $todoList->title }}</h2>     
    <p>Статус: {{ $todoList->is_public ? 'Публичный' : 'Приватный' }}</p>     

    <!-- Поле для добавления задачи доступно только для авторизованных пользователей -->  
    @auth  
        <h4>Добавить новую задачу</h4>     
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
    @endauth  

    <h4>Задачи</h4>     
    <table>
        <thead>
            <tr>
                <th>Название задачи</th>
                <th>Автор</th>
                <th>Статус</th>
                <th>Статус 2</th>
                <th>Кнопки</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)     
                <tr>     
                    @if ($editingTaskId === $task->id)     
                        <!-- Режим редактирования -->
                        <td>
                            <input type="text" wire:model="editingTaskTitle">
                        </td>
                        <td>{{ $task->user->name }}</td>
                        <td>
                            <select wire:model="editingTaskVisibility">     
                                @foreach ($visibilityOptions as $option)     
                                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>     
                                @endforeach     
                            </select>     
                        </td>
                        <td>
                            <select wire:model="editingTaskCompletionStatus">     
                                @foreach ($completionStatusOptions as $option)     
                                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>     
                                @endforeach     
                            </select>     
                        </td>
                        <td>
                            <button wire:click="updateTask">Сохранить</button>     
                            <button wire:click="$set('editingTaskId', null)">Отмена</button>
                        </td>
                    @else     
                        <!-- Режим просмотра -->
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->user->name }}</td>
                        <td>{{ ucfirst($task->visibility) }}</td>
                        <td>{{ ucfirst($task->completion_status) }}</td>
                        <td>
                            <!-- Управление задачей доступно только владельцу -->  
                            @can('update', $task)   
                                <button wire:click="editTask({{ $task->id }})">Редактировать</button>     
                                <button wire:click="deleteTask({{ $task->id }})">Удалить</button>     
                            @endcan
                        </td>
                    @endif     
                </tr>     
            @endforeach     
        </tbody>
    </table>
</div>