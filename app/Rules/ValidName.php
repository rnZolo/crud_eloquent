<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\LocalStudent;
use App\ForeignStudent;
use Illuminate\Support\Arr;


class ValidName implements Rule
{
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
        // dd(getType(request()->method()));
        if(request()->method() == 'PUT'){
            if(LocalStudent::whereRaw('name = ? and not id_number = ?', [$value, request()->old_id_number])->get()->count() == 1){ // same name checking
                $n_record = LocalStudent::whereRaw('name = ? and not id_number = ?', [$value, request()->old_id_number])->get()->toArray();
                $n_record = $n_record[0]['mobile_number'];   
                if(($n_record == request()->mobile_number)){ // should be unique
                    return false;
               }
    
            }else{ // unique name // same name checking
                // dd(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count());
                if(!(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count() <= 1 )){ // not  0 or 1 same number
                   return false;
                }
            }
     
            // same name then same number false
            // unique name verify 0 or 1 same number
            if(ForeignStudent::whereRaw('name = ? and not id_number = ?', [$value, request()->old_id_number])->get()->count() == 1){ // same name checking
                $n_record = ForeignStudent::whereRaw('name = ? and not id_number = ?', [$value, request()->old_id_number])->get()->toArray();
                $n_record = $n_record[0]['mobile_number'];
                if(($n_record == request()->mobile_number)){ // should be unique
                    return false;
               }
    
            }else{ // unique name // same name checking
                // dd(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count());
                if(!(ForeignStudent::where('mobile_number', request()->mobile_number)->get()->count() <= 1 )){ // not  0 or 1 same number
                   return false;
                }
            }
            return true;
        }
        if(request()->method() == 'POST'){
           
                // same name then same number false
                // unique name verify 0 or 1 same number

                if(LocalStudent::where('name', $value)->get()->count() == 1){ // same name checking
                    $n_record = LocalStudent::where('name', $value)->get()->toArray();
                    $n_record = $n_record[0]['mobile_number'];
                    if(($n_record == request()->mobile_number)){ // should be unique
                        return false;
                   }

                }else{ // unique name // same name checking
                    if(!(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count() <= 1 )){ // not  0 or 1 same number
                        return false;                   
                    }
                }

                // same name then same number false
                // unique name verify 0 or 1 same number
                
                if(ForeignStudent::where('name', $value)->get()->count() == 1){ // double entry // same name checking
                    $n_record = ForeignStudent::where('name', $value)->get()->toArray();
                    $n_record = $n_record[0]['mobile_number'];
                    if(($n_record == request()->mobile_number)){ // should be unique
                        return false;
                   }
                }else{ // unique name // same name checking
                    if(!(ForeignStudent::where('mobile_number', request()->mobile_number)->get()->count() <= 1 )){ // not  0 or 1 same number
                        // dd(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count(), 'must unique of same with 1 number');
                        return false;
                    }
                }
                return true;
  
        }
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Name with Phone Number already exist';
    }
}
