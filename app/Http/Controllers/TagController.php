<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
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
    public function index()
    {
        $tags = Tag::select('id', 'name')->simplePaginate(10);
        return response()->json($tags, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag) // Todo [] Show Method 
    {
        return response()->json([
            'tag id' => $tag->id,
            'tag name' => $tag->name,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)  // 201
    {
        // Update Tag information -> Create requests
        $tag->update($request->validated());
        return response()->noContent(204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->noContent(204);
    }
}
