<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

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

}
