<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::with(['tags', 'users', 'status']);
        return TodoResource::collection($todos->simplePaginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request)
    {  
        $todo = Todo::create($request->safe()->except(['assign_to', 'tag_id'])); 
        $todo->users()->attach($request['assign_to']);
        $todo->tags()->attach($request['tag_id']);
        return new TodoResource($todo->load('users', 'tags', 'status')); 

        // * The response does not show users and tags due as they are not presisting in this case. They are used for relationship purposes only
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return new TodoResource($todo->load('users', 'tags', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->safe()->except(['assign_to', 'tag_id']));
        $todo->users()->sync($request['assign_to']);
        $todo->tags()->sync($request['tag_id']);
        return new TodoResource($todo->load('users', 'tags', 'status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->users()->detach();
        $todo->tags()->detach();
        $todo->delete();
    }
}
