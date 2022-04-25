<?php

namespace App\Models;

use App\Scopes\AutScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Pipeline\Pipeline;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Todo extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes, HasRecursiveRelationships;

    protected $fillable = [
        'title',
        'content',
        'status_id',
        'parent_id'
    ];

    protected $casts = [
        'tag_id' => 'array',
        'assign_to' => 'array',
        'children' => 'array',
    ];

    public static function allTodos()
    {
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
    ];

    public function users()
    { // M:N 
        return $this->belongsToMany(User::class)
            ->whereNull('todo_user.deleted_at')
            ->withTimestamps();
    }

    public function tags()
    { // M:N
        return $this->belongsToMany(Tag::class)
            ->whereNull('tag_todo.deleted_at')
            ->withTimestamps();
    }

    public function status()
    { // 1:N The todo will have the foriegn key as is in the current system
        return $this->belongsTo(Status::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    // * Static
    // public function scopeAut($query){
    //     return $query->where('title', 'aut');
    // }

    // * Dynamic 
    // public function scopeTitle($query, $value){
    //     return $query->where('title', $value);
    // }
    

    // * ==============================

}
