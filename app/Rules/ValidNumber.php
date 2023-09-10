<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use App\LocalStudent;
use App\ForeignStudent;

class ValidNumber implements Rule
{
    protected $message = 'Mobile Number has been used twice';
    protected $number_local;
    protected $number_foreign;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(request()->method() == 'PUT'){
            // exclude tha record to be updated then get the result
            $query_values = [$value, request()->old_id_number];

            $this->number_local = LocalStudent::whereRaw('mobile_number = ? and not id_number = ?',
                                        $query_values)->get();
            $this->number_foreign = ForeignStudent::whereRaw('mobile_number = ? and not id_number = ?',
                                        $query_values)->get();

        }else if(request()->method() == 'POST'){
            $this->number_local = LocalStudent::where('mobile_number', $value)->get();
            $this->number_foreign = ForeignStudent::where('mobile_number', $value)->get();
        }

        // number exist once on both table
        if($this->number_local->count() > 0  & $this->number_foreign->count() > 0){
            // $this->message = 'each table has one record';
            return false;
        }
        // number exist twice on either of the table
        if($this->number_local->count() > 1 or $this->number_foreign->count() > 1){
            // $this->message = 'one of table has 2';
            return false;
        }
        // if number exist once check if same name
        if($this->number_local->count() == 1){
            $valid = $this->checkName($this->number_local, request('name'));
            if(!$valid) return false;

        }
        if($this->number_foreign->count() == 1){
            $valid = $this->checkName($this->number_foreign, request('name'));
            if(!$valid) return false;

        }

        return true;
    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    protected function checkName(Object $obj, String $name){
        $valid = true;
        $record = $obj->toArray(); // [0 => values]
        $record = Arr::collapse($record); // [values]

        if(strtolower($record['name']) == strtolower($name)){  // offset error
            $this->message = 'Mobile Number exist with the same Name';
            $valid = false;
        }

        return $valid;
    }

}
