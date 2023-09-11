<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AllStudent;

class ForeignStudent extends Model
{
    protected $table = 'foreign_students';
    protected $guarded = ['id'];
    protected $fillable = ['student_type', 'id_number',
                            'name', 'age', 'gender', 'city',
                            'mobile_number', 'email', 'grades'];

    function inAllStudent(){
        return $this->hasOne(AllStudent::class, 'id');
    }

}
