<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentInformation;
use Illuminate\Database\Eloquent\Model;
use App\AllStudent;
use App\LocalStudent;
use App\ForeignStudent;



class AllStudentController extends Controller
{
    protected function index(){ 
        
        // if($type == "all"){
            $datas = AllStudent::with(['localStudent', 'foreignStudent'])->get();
            foreach( $datas as $data ){
                $students[] = $data['local_student'] ?? $data['foreign_student'];
            }
     
            return view('page.admin.index', compact('students'));
        // }else if($type == "local_students"){
        //     return 'local';
        // }else if($type == "foreig_student"){
        //     return 'local';
        // }
    }

    protected function create(){
        return view('page.admin.create');
    }

    protected function store(StudentInformation $request){

        if($request->student_type === "foreign"){
            $status =  $this->saveStudent($request, $student = new ForeignStudent, $request->student_type);  
            return $status ? back()->with('store', 'Success') : back()->with('store', 'failed')->with('store', 'failed');

        }else if ($request->student_type === "local"){
            $status =  $this->saveStudent($request, $student = new LocalStudent, $request->student_type);                            
            return $status ? back()->with('store', 'Success') : back()->with('store', 'failed')->with('store', 'failed');
            
        }
    }

    protected function show(){
        
    }

    protected function edit(AllStudent $id){
        dd($id->foreign_student_id);
        if(!$id->foreign_student_id == null){

        }
        // return 
    }

    protected function saveStudent($request, Model $model, $student_type){
        // dd($request);
        $m = new $model;
        $m =  $m::create($request->all());

        $m::findOrFail($m->id);
        $student = new AllStudent();
        $student->student_type = $student_type;
        $this->studentType($student_type,  $m->id, $student);
        if( $student->save()){
            return true;
        }else{
            return false;
        }
                
    }      
    
    protected function studentType($student_type, $id, Model $model){
        if($student_type == 'local'){
            $model->local_student_id = $id;
        }else if($student_type == 'foreign') {
           $model->foreign_student_id = $id;
        }
    }
}
