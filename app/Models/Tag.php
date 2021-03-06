<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes, HasFactory;

    protected $fillable = ['name'];

    public function todos() {
        return $this->belongsToMany(Todo::class)->withTimestamps();
    }
}

