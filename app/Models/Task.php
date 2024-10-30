<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'completion_status',
        'visibility',
    ];

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
