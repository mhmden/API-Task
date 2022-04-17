<?php
namespace App\Services;

use App\Models\Todo;
use Illuminate\Support\Facades\DB;

class TodoService{

    public function createTodo($validData) // * Pass in $request->safe() to use things such as except and only.
    {
        return DB::transaction(function () use ($validData) {
            $todo = Todo::create($validData->except(['assign_to', 'tag_id', 'file']));
            $todo->users()->attach($validData->assign_to);
            $todo->tags()->attach($validData->tag_id);
            if ($files = $validData->file) { // * Array of files and if files exist too because they are nullable in the rule
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->store('files', 'public');
                    $todo->files()->create([
                        'name' => $name,
                        'path' => $path,
                    ]);
                }
            }    
            return $todo;
        });
    }

}

// Validate Individually