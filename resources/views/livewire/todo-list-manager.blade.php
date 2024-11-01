<div>     
   <h3>Todo Списки</h3>     

   <!-- Поле для создания нового списка доступно только для авторизованных пользователей -->   
   @auth   
       <input type="text" wire:model="title" placeholder="Название списка">     
       <label>     
           <select wire:model="isPublic">     
               <option value="private">Приватный</option>     
               <option value="public">Публичный</option>     
           </select>     
       </label>     
       <button wire:click="createTodoList">Создать список</button>     
   @endauth   

   <table>
       <thead>
           <tr>
               <th>Название списка</th>
               <th>Автор</th>
               <th>Статус</th>
               <th>Кнопки</th>
               <th>Ссылка для публичных списков</th>
           </tr>
       </thead>
       <tbody>
           @foreach ($todoLists as $list)     
               <tr>     
                   @if ($editingListId === $list->id)  
                       <!-- Поля редактирования для списка -->  
                       <td>
                           <input type="text" wire:model="editingListTitle" placeholder="Название списка">  
                       </td>
                       <td>{{ $list->user->name }}</td>
                       <td>
                           <select wire:model="editingListVisibility">  
                               <option value="private">Приватный</option>  
                               <option value="public">Публичный</option>  
                           </select>
                       </td>
                       <td>
                           <button wire:click="updateTodoList">Сохранить</button>  
                           <button wire:click="$set('editingListId', null)">Отмена</button>
                       </td>
                       <td></td>
                   @else  
                       <td>
                           <!-- Ссылка на список задач в режиме просмотра -->  
                           <a href="{{ route('todo-list.show', $list->id) }}">     
                               {{ $list->title }}     
                           </a>
                       </td>
                       <td>{{ $list->user->name }}</td>
                       <td>{{ $list->is_public ? 'Публичный' : 'Приватный' }}</td>
                       <td>
                           <!-- Управление списком доступно только владельцу -->   
                           @can('update', $list)    
                               <button wire:click="deleteTodoList({{ $list->id }})">Удалить</button>     
                               <button wire:click="editTodoList({{ $list->id }}, '{{ $list->title }}', '{{ $list->is_public ? 'public' : 'private' }}')">Редактировать</button>  
                           @endcan
                       </td>
                       <td>
                           <!-- Публичные списки можно скопировать -->   
                           @if ($list->is_public)     
                               <input type="text" value="{{ route('todo-list.show', $list->id) }}" readonly>     
                               <button onclick="navigator.clipboard.writeText('{{ route('todo-list.show', $list->id) }}')">Копировать ссылку</button>     
                           @endif
                       </td>
                   @endif     
               </tr>     
           @endforeach     
       </tbody>
   </table>     
</div>