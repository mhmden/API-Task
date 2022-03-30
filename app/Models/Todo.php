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
        'tag_id',
    ];

    public function users (){
        return $this->belongsToMany(User::class);
    }

    public function tag(){
        return $this->belongsTo(Tag::class);
    }

}
