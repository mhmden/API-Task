<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;
use App\Models\User;
use App\Models\Tag;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
        
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
        // ? Associate a single todo by a tag
        $todo = Todo::create($request->validated());
        return response()->json($todo);








        // * Something is off here, You are right. Attach can take arrays. Re-think this
        // $usersToFind = array_unique($request['assignTo']);
        // $foundUsers = User::find($usersToFind)->count();

        // if(!($foundUsers == count($usersToFind))){ 
        //     return response()->json('Some Items were not found');
        // }
        // $todo = Todo::create([
        //     'title' => $request->validated(['title']),
        //     'content' => $request->validated(['content']),
        // ]);

        // $todo->users()->attach($usersToFind);
        return response()->json('Operation Succeded');
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
