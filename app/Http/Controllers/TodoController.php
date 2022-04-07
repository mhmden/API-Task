<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;

class TodoController extends Controller
{
    // TODO [X] find the proper http codes for: created, updated, deleted
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index() // TODO [] Re-Evaluate This stuff
    {

        $todos = Todo::select(['id', 'title', 'content', 'status_id'])->with(['tags:id,name', 'users:id,name', 'status:id,name'])->simplePaginate(10);
        return $todos;
        return TodoResource::collection($todos)->response()->setStatusCode(200); // Done Automatically in Insomnia
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->validated());
        $todo->users()->attach($request['assign_to']);
        $todo->tags()->attach($request['tag_id']);
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
