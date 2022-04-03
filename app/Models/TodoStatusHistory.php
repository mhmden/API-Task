<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoStatusHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['todo_id', 'status_id'];
}
