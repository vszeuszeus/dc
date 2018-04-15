<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListerRequest extends FormRequest
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
            'title' => 'string|required|max:100|unique:lecture_categories,title,'.(isset($this->id) ? $this->id : 'NULL').',id'
        ];
    }
}
