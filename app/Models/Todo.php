<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Pipeline\Pipeline;

class Todo extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'status_id'
    ];

    protected $casts = [
        'todo_tag' => 'array',
        'assign_to' => 'array',
    ];

    public static function allTodos (){
        return app(Pipeline::class)
                        ->send(Todo::query())
                        ->through(Todo::PIPES)
                        ->thenReturn()
                        ->get();
    }

    const PIPES = [
        \App\TodoQueryFilters\Title::class,
        \App\TodoQueryFilters\Content::class,
        \App\TodoQueryFilters\Status::class,
        \App\TodoQueryFilters\Tags::class,
        \App\TodoQueryFilters\Users::class,
        \App\TodoQueryFilters\Files::class,
        \App\TodoQueryFilters\Date::class,
        // TODO created_at filter

        // Todo -> Could add more filters relevant to time, and possibly hide todos by banned users.
    ];

    public function users (){ // M:N 
        return $this->belongsToMany(User::class)
                    ->whereNull('todo_user.deleted_at')
                    ->withTimestamps();
    }

    public function tags(){ // M:N
        return $this->belongsToMany(Tag::class)
                    ->whereNull('tag_todo.deleted_at')
                    ->withTimestamps();
    }

    public function status(){ // 1:N The todo will have the foriegn key as is in the current system
        return $this->belongsTo(Status::class);
    }

    public function statusHistory() {
        return $this->hasMany(StatusHistory::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

}
