<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Support\Arr;

class TodoService
{

    /** 
     * ? Create the first todo,
     * ? If Children exist
     * ? Loop through them and create the todo via the children relationship.
     * ?
     * 
     */

    public function CreateTodoWithChildren($request){
        $todo = $this->createTodo($request->safe());
        $kids = (!empty($todo->children)) ?: $this->createChildren($request->children, $todo);
        return (!isset($kids)) ? $todo: $todo->bloodline();
    }



    public function createTodo($validData) // Has to be safe()
    {
        // $valid = $request->safe(); // To use only and except
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
    }

    public function createChildren($children, $todo)
     {
        if (!empty($children)) { 
            foreach ($children as $child){ // * Child is each array
                $x = $todo->children()->create(Arr::except($child, ['assign_to', 'tag_id', 'file']));
                $x->users()->attach($child['assign_to']);
                $x->tags()->attach($child['tag_id']);
                if (Arr::has($child, 'file')){ // ? This condition is messed up
                    foreach ($child['file'] as $file) {
                        $name = $file->getClientOriginalName();
                        $path = $file->store('files', 'public');
                        $x->files()->create([
                            'name' => $name,
                            'path' => $path,
                        ]);
                    }
                }
            }
            return $todo->children()->get();
        }
    }
}

// Validate Individually