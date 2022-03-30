<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;
use App\Models\User;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all(['id', 'title', 'content', 'created_at']);
        
        return ($todos->isEmpty()) ? response()->json('You have no todos') : response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request) // Store method should have a parmeter, that parameter should be validated
    {
        // * Something is off here
        $usersToFind = $request['assignTo'];
        $foundUsers = User::find($usersToFind);

        if(!count($usersToFind) > count($foundUsers)){ // Match input with output
            return response()->json('Some Items were not found');
        }
        $todo = Todo::create([
            'title' => $request->validated(['title']),
            'content' => $request->validated(['content']),
        ]);
        foreach($foundUsers as $user){
            $user->todos()->attach($todo); // This is the magic
        }
        return response()->json('Todo creation is successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo) // Route Model Binding Here <- Show todo via ID
    {
        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoRequest $request, Todo $todo) // Update a specific todo PATCH
    {
        $todo->update([
            'title' => $request->validated('title'),
            'content' => $request->validated('content'),
        ]);
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo) // Delete Todo DELETE request
    {
        $todo->delete(); // soft
        return response()->json('Todo was deleted');
    }
}
