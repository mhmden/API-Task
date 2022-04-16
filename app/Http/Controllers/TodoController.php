<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\TodoRequest;

use App\Http\Resources\TodoResource;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::allTodos();

        return response()->json($todos);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $validData = $request->validated(); // * Validate Everything
        $todo = Todo::create($request->except(['assign_to', 'tag_id', 'file']));
        $todo->users()->attach($request->assign_to);
        $todo->tags()->attach($request->tag_id);

        if ($files = $request->file('file')) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('files', 'public'); // * Second Parameter is for disk

                $todo->files()->create([
                    'name' => $name,
                    'path' => $path,
                ]);
            }
        }

        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return (new TodoResource($todo->load('users', 'tags', 'status')))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        $todo->users()->sync($request['assign_to']);
        $todo->tags()->sync($request['tag_id']);
        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->users()->update([
            'todo_user.deleted_at' => now(),
        ]);
        $todo->tags()->update([
            'tag_todo.deleted_at' => now(),
        ]);
        $todo->delete();

        return response()->noContent(204);
    }
}
