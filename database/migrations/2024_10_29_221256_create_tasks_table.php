<?php 

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 

return new class extends Migration 
{ 
    /** 
     * Run the migrations. 
     */ 
    public function up() 
    { 
       Schema::create('tasks', function (Blueprint $table) { 
           $table->id(); 
           $table->foreignId('todo_list_id')->constrained()->onDelete('cascade'); 
           $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Связь с таблицей users
           $table->string('title'); 
           $table->enum('visibility', ['public', 'private'])->default('private'); 
           $table->enum('completion_status', ['completed', 'canceled'])->default('canceled'); 
           $table->timestamps(); 
       }); 
    } 

    /** 
     * Reverse the migrations. 
     */ 
    public function down(): void 
    { 
        Schema::dropIfExists('tasks'); 
    } 
};