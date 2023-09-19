<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\ValidName;
use App\Rules\ValidNumber;
use App\LocalStudent;
use App\ForeignStudent;

class StudentInformation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = request()->method();
        return [
                'student_type' => [
                    'bail', 'required',
                    Rule::in(['local', 'foreign']),
                    ],
                'id_number' => $method == 'POST' ? 
                        'bail|required|integer|digits_between:1,5|min:0|
                        unique:App\LocalStudent,id_number|unique:App\ForeignStudent,id_number' :
                        [
                            'required', 'numeric', 'digits_between:1,5', 'min:0',
                            Rule::unique(LocalStudent::class)->ignore(request()->old_id_number, 'id_number'),
                            Rule::unique(ForeignStudent::class)->ignore(request()->old_id_number, 'id_number'),
                    ],
                'name' => ['bail', 'required', 'string', 'max:30', 'min:2',
                        new ValidName()
                    ],
                'age' => ['bail','required','numeric','min:7', 'max:150'],
                'gender' => ['bail', 'required',
                    Rule::in(['male', 'female']),
                    ],
                'city' => 'bail|required|string|max:150',
                'mobile_number' => ['bail', 'required','regex:/^63[9]\d{9}$/',
                                new ValidNumber()
                    ],
                'email' => 'bail|required|email:dns',
                'grades' => "nullable|bail|numeric|between:75,99.99|regex:/^[0-9]*(\.[0-9]{0,2})?$/",
        ];
    }

    public function messages(){
        return [
            'id_number.integer' => "ID number shouldn't start with 0",
            'id_number.digits_between' => 'ID number is 1 - 5 digits only',
            'mobile_number.regex'=> 'Mobile number must start with 63 and 12 digits',
            'grades.regex'=> 'Max decimal is 2',
        ];
    }
}
