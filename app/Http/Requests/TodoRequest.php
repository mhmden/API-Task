<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $users = $this->assign_to;
        $tags = $this->tag_id;

        
        return [
            'parent_id' => 'nullable|exists:todos,id', // ? Beaware of How nullable and sometimes differ
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status_id' => 'required|numeric|exists:statuses,id',
            'assign_to' => 'required|exists:users,id',
            'tag_id' => 'required|exists:tags,id',
            'file' => 'nullable|array|between:1,5',
                'file.*' => 'nullable|file|mimetypes:text/plain|max:2048' ,
            'children' => 'nullable|array',
                'children.*.title' => 'required|string|max:255',
                'children.*.content' => 'required|string',
                'children.*.status_id' => 'required|numeric|exists:statuses,id',
                'children.*.assign_to' => ['required', 'array', Rule::in($users)],
                'children.*.tag_id' => ['required', 'array', Rule::in($tags)],
                'children.*.file' => 'nullable|array|between:1,3',
                'children.*.file.*' => 'nullable|file|mimetypes:text/plain|max:2048' ,
        ];
    }
}
