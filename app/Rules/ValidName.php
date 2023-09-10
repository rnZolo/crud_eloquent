<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\LocalStudent;
use App\ForeignStudent;
use Illuminate\Support\Arr;


class ValidName implements Rule
{

    protected $message = 'Name with Phone Number already exist' ;
    protected $name_local;
    protected $name_foreign;

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        // check what request method PUT/Update POST/store assign values base from it
        if(request()->method() == 'PUT'){
            $query_values = [$value, request()->old_id_number];
            $this->name_local = LocalStudent::whereRaw('name = ? and not id_number = ?',
                                            $query_values)->get();
            $this->name_foreign = ForeignStudent::whereRaw('name = ? and not id_number = ?',
                                            $query_values)->get();

        }else if(request()->method() == 'POST'){
            $this->name_local = LocalStudent::where('name', $value)->get();
            $this->name_foreign = ForeignStudent::where('name', $value)->get();

        }
            if(!preg_match('/^[A-Za-z. ]+$/', $value)){
                $this->message = 'Name should not contain snumbers';
                return false;
            }
            // name exist with the same number
            if(($count = $this->name_local->count()) >= 1){ // same name checking
                $valid = $this->checkNumber($this->name_local, request('mobile_number'), $count);
                if(!$valid) return false;

            }
            if(($count = $this->name_foreign->count()) >= 1){
                $valid = $this->checkNumber($this->name_foreign, request('mobile_number'), $count);
                if(!$valid) return false;

            }

        return true;
    }

    public function message(){
        return $this->message;

    }

    protected function checkNumber(Object $obj, $mobile_number, $count){
        $valid = true;
        $record = $obj->toArray();
        for($c = 0; $c < $count; $c++){
            if($record[$c]['mobile_number'] == $mobile_number){
                $this->message = 'Name exist with the same Mobile Number';
                $valid = false;
            }
        }

        return $valid;
    }
}
