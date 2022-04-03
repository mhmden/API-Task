<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
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
        $todos = Todo::simplePaginate(10);
        return response()->json($todos);
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
        return response()->json([
            'id' => $todo->id,
            'title' => $todo->title,
            'content' => $todo->content,
            'tags' => $todo->tags->pluck('name'),
            'status' => $todo->status->name,
            'users' => $todo->users->pluck('id', 'name'),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        // return response()->json( $todo::with('status', 'tags')->get(['id', 'title'])   , 200);
        return response()->json([
            'id' => $todo->id,
            'title' => $todo->title,
            'content' => $todo->content,
            'tags' => $todo->tags->pluck('name'),
            'status' => $todo->status->id,
            'users' => $todo->users->pluck('id', 'name'),
        ], 200);
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

        return response()->json([
            'id' => $todo->id,
            'title' => $todo->title,
            'content' => $todo->content,
            'tags' => $todo->tags->pluck('name'),
            'status' => $todo->status->id,
            'users' => $todo->users->pluck('id', 'name'),
        ], 200);
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
        return response()->json('Todo was deleted');
    }
}
