<?php

namespace App\Services;

use App\Models\Todo;

class TodoService
{

    /** 
     * ? Create the first todo,
     * ? If Children exist
     * ? Loop through them and create the todo via the children relationship.
     * ?
     * 
     */

    public function createTodo($input)
    {
        $valid = $input->safe();
        $todo = Todo::create($valid->except(['assign_to', 'tag_id', 'file']));
        $todo->users()->attach($valid->assign_to);
        $todo->tags()->attach($valid->tag_id);
        if ($files = $input->safe()->file) { // * Array of files and if files exist too because they are nullable in the rule
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('files', 'public');
                $todo->files()->create([
                    'name' => $name,
                    'path' => $path,
                ]);
            }
        }
        // $arr = $valid->children;
        
        $kids = $todo->children()->createMany($valid->children);
        return $todo;
    }
}

// Validate Individually