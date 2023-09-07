<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocalStudent;
use App\ForeignStudent;

class AllStudent extends Model
{
    protected $table = 'all_students';
    protected $fillable = ['student_type', 'local_student_id',
                            'foreign_student_id'];

    public function localStudent(){
        return $this->belongsTo(LocalStudent::class, 'local_student_id', 'id');
    }

    public function foreignStudent(){
        return $this->belongsTo(ForeignStudent::class, 'foreign_student_id', 'id');
    }
    
}
