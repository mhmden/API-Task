<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Todo;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // * Show Tag with underlying Todo
    {
        // $tag = Tag::with('todos');
        return TagResource::collection(Tag::all()); // This needs to be paginated

        // $tags = Tag::with('todos')->get();
        // return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->validated());
        // view the created tag
        return new TagResource($tag);
        // return response()->json($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag) // Todo [] Show Method 
    {
        return new TagResource($tag);
        // $tag = Tag::with('todos')->get();
        // return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) 
    {
        //
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
