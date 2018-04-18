<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
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
            'title' => 'required|unique:lectures,title,' .
                (($this->route('lecture')) ? $this->route('lecture') : "NULL") . ',id|max:255|string',
            'lecture_category_id' => 'required|exists:lecture_categories,id|integer',
            'body' => 'required|max:10000|string'
        ];
    }
}
