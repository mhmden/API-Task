<?php

namespace App\Http\Requests;

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
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'assign_to' => 'required|exists:users,id',
            'tag_id' => 'required|exists:tags,id',
            'file.*' => 'nullable|mimetypes:text/plain|max:2048' // This equates to an optional array ? and we used mimetypes because mimes don't behave as expected for some reason.
        ];
    }
}
