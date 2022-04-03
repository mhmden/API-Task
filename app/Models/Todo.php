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
        'todo_tag',
        'assign_to',
        'status_id',
    ];

    public function users (){ // M:N 
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tags(){ // M:N
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function status(){ // 1:N The todo will have the foriegn key as is in the current system
        return $this->belongsTo(Status::class);
    }

    public function statusHistory() {
        return $this->hasMany(StatusHistory::class);
    }

}
