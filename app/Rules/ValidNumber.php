<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\LocalStudent;
use App\ForeignStudent;

class ValidNumber implements Rule
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
            $local = LocalStudent::whereRaw('name = ? and not id_number = ?', [$value, request()->old_id_number])->get();
            if($local->count() == 1){ // same name checking
                $n_record = $local->toArray();
                $n_record = $n_record[0]['mobile_number'];   
                if(($n_record == request()->mobile_number)){ // should be unique
                    return false;
               }
    
            }else{ // unique name // same name checking
                // dd(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count());
                if(!(LocalStudent::where('name', request()->mobile_number)->get()->count() <= 1 )){ // not  0 or 1 same number
                    return false;
                 }
            }
     
            // same name then same number false
            // unique name verify 0 or 1 same number
            $foreign = ForeignStudent::whereRaw('id_number = ? and not name  = ?', [request()->old_id_number, $value])->get();
            if($foreign->count() == 1){ // same name checking
                $n_record = $foreign->toArray();
                $n_record = $n_record[0]['name'];
                if(($n_record == request()->name)){ // should be unique
                    return false;
               }
    
            }else{ // unique name // same name checking
                // dd(LocalStudent::where('mobile_number', request()->mobile_number)->get()->count());
                if(!(ForeignStudent::where('name', request()->mobile_number)->get()->count() <= 1 )){ // not  0 or 1 same number
                   return false;
                }
            }
            return true;
        }
        if(request()->method() == 'POST'){
           
                // same name then same number false
                // unique name verify 0 or 1 same number
                
                if(LocalStudent::where('mobile_number', $value)->get()->count() == 1){ // same number checking
                    
                    $n_record = LocalStudent::where('mobile_number', $value)->get()->toArray();
                    $n_record = $n_record[0]['name'];
                    if(($n_record == request()->name)){ // should be unique
                        return false;
                   }

                }else{ // unique number // same name checking
                    if(!(LocalStudent::where('name', request()->name)->get()->count() <= 1 )){ // not  0 or 1 same number
                        return false;                   
                    }
                }

                // same name then same number false
                // unique name verify 0 or 1 same number
                // dd(LocalStudent::where('mobile_number', $value)->get()->count());
                if(ForeignStudent::where('mobile_number', $value)->get()->count() == 1){ // same number checking
                    $n_record = LocalStudent::where('mobile_number', $value)->get()->toArray();
                    $n_record = $n_record[0]['name'];
                    if(($n_record == request()->name)){ // should be unique
                        return false;
                   }

                }else{ // unique name // same name checking
                    if(!(ForeignStudent::where('name', request()->name)->get()->count() <= 1 )){ // not  0 or 1 same number
                        return false;                   
                    }
                }
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
        return 'Phone Number has been used';
    }
}
