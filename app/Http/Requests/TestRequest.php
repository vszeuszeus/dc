<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
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
            'title' => 'required|unique:tests,title,' .
                (($this->input('id')) ? $this->input('id') : "NULL") . ',id|max:255|string',
            'testable_type' => 'in:App\\LectureCategory,App\\Lecture',
            'testable_id' => 'required|exists:' . (($this->testable_type == 'App\\LectureCategory') ?
                    'lecture_categories' : 'lectures') . ',id|integer'
        ];
    }
}
