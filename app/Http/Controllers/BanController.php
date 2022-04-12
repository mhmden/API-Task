<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::whereNotNull('banned_at')->get(['id', 'name']);
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // UnBan
    {
        //
        $user = User::find($id);
        $user->update(['banned_at' => null]);
        return response()->json([
            'User' => $user->name,
            'message' => 'Has been Unbanned'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) // ban ?
    {
        $user = User::find($id);
        $user->update(['banned_at' => now()]);
        $user->tokens()->delete(); 
        return response()->json([
            'User' => $user->name,
            'message' => 'Has been Unbanned'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
