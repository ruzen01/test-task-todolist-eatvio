<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'visibility',
        'completion_status',
        'todo_list_id',
        'user_id', // Убедитесь, что поле user_id также включено
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
