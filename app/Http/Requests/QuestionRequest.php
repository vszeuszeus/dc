<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'title' => 'required|max:255|unique:questions,title,' .
                (($this->input('id')) ? $this->input('id') : "NULL") . ',id|max:255|string',
            'test_id' => 'required|integer|exists:tests,id',
            'answers' => 'required|array|min:1',
            'answers.*' => 'required|array',
            'answers.*.title' => 'required|distinct|max:255',
            'answers.*.trusted' => 'required'
        ];
    }
}
