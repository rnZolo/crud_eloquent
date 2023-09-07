<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentInformation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'student_type' => [
                    'bail', 'required', 
                    Rule::in(['local', 'foreign']),
                    ],
                'id_number' => 'bail|required|numeric|digits_between:1,5|min:1',
                'name' => 'bail|required|string|max:30|min:2',
                'age' => 'bail|required|numeric|digits_between:1,3|min:7', 
                'gender' => [
                    'bail', 'required', 
                    Rule::in(['male', 'female']),
                    ],
                'city' => 'bail|required|string|max:150', 
                'mobile_number' => 'bail|required|regex:/^63[9]\d{9}$/',
                'email' => 'email:dns', 
                'grades' => "nullable|bail|numeric|between:75,99|regex:/^\d+(\.\d{1,2})?$/", 
        ];
    }
}
