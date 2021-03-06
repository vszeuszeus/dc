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
            'title' => 'string|required|max:255|unique:lecture_categories,title,'.($this->route('lister') ? $this->route('lister') : 'NULL') .',id'
        ];
    }
}
