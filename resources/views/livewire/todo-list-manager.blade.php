<div>
   <h3>Todo Списки</h3>

   <input type="text" wire:model="title" placeholder="Название списка">
   <label>
       <select wire:model="isPublic">
           <option value="private">Приватный</option>
           <option value="public">Публичный</option>
       </select>
   </label>
   <button wire:click="createTodoList">Создать список</button>

   <ul>
       @foreach ($todoLists as $list)
           <li>
               <a href="{{ route('todo-list.show', $list->id) }}">
                   {{ $list->title }}
               </a> 
               ({{ $list->is_public ? 'Публичный' : 'Приватный' }})
               <button wire:click="togglePrivacy({{ $list->id }})">
                   Сделать {{ $list->is_public ? 'Приватным' : 'Публичным' }}
               </button>
               <button wire:click="deleteTodoList({{ $list->id }})">Удалить</button>

               @if ($list->is_public)

                       <input type="text" value="{{ route('todo-list.show', $list->id) }}" readonly>
                       <button onclick="navigator.clipboard.writeText('{{ route('todo-list.show', $list->id) }}')">Копировать ссылку</button>

               @endif

           </li>
       @endforeach

   </ul>
</div>