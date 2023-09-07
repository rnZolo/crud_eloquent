<?php

namespace App;
use App\AllStudent;
use App\ForeignStudent;

use Illuminate\Database\Eloquent\Model;

class LocalStudent extends Model
{
    protected $table = 'local_students';
    protected $fillable = ['student_type', 'id_number',
                            'name', 'age', 'gender', 'city',
                            'mobile_number', 'email', 'grades'];

    function inAllStudent(){
        return $this->hasOne(AllStudent::class, 'id');

    }
}
