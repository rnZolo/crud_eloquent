<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\LocalStudent;
use App\ForeignStudent;
use App\Rules\ValidName;
use App\Rules\ValidNumber;

class UpdateStudentInformation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::check()){
            return false;
        }

        return true;
    }
                  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd(request()->method);
        // dd((request()->old_id_number), request()->id_number); // id - request
        return [
            'student_type' => [
                'bail', 'required', 
                Rule::in(['local', 'foreign']),
                ],
            'id_number' => [
                    'required', 'numeric', 'digits_between:1,5', 'min:0',
                    Rule::unique(LocalStudent::class)->ignore(request()->old_id_number, 'id_number'),
                    Rule::unique(ForeignStudent::class)->ignore(request()->old_id_number, 'id_number'),
            ],
            'name' => ['bail', 'required', 'string', 'max:30', 'min:2',
                        new ValidName()
            ],
            'age' => 'bail|required|numeric|digits_between:1,3|min:7', 
            'gender' => [
                'bail', 'required', 
                Rule::in(['male', 'female']),
                ],
            'city' => 'bail|required|string|max:150', 
            'mobile_number' => ['bail', 'required','regex:/^63[9]\d{9}$/',
                            new ValidNumber()   
                ],
            'email' => 'email:dns', 
            'grades' => "nullable|bail|numeric|between:75,100|regex:/^\d+(\.\d{1,2})?$/", 
        ];
    }
}
