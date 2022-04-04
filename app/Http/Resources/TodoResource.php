<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [ // All lazy loaded for now. 
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'status' => (new StatusResource($this->whenLoaded('status'))),  // A single resource due to relationship type
        ];
    }
}
// Todo [X] Status Resource does not function when the todo is calling it M ------- 1
// Due to the nature of the relationship
