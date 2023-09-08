<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentInformation;
use App\Http\Requests\UpdateStudentInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\AllStudent;
use App\LocalStudent;
use App\ForeignStudent;



class AllStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index(){ 
        // dd(request()->filter_by);
        request()->filter_by ?? 'all';
        if(request()->filter_by == 'all'){
            $datas = AllStudent::with(['localStudent', 'foreignStudent'])->get()->toArray();
           
            foreach( $datas as $data ){
                $students[] = $data['local_student'] ?? $data['foreign_student'];
            }
            return view('page.admin.index', compact('students'));
        }

        if(request()->filter_by == 'local_only'){
            $datas = AllStudent::with(['localStudent'])->get()->toArray();
            // dd($datas);
            foreach( $datas as $data){
                //  dd($data);
                if(!($data['local_student'] == null)){
                    $students[] = $data['local_student'];
                }

            }
            return view('page.admin.index', compact('students'));
        }

        if(request()->filter_by == 'foreign_only'){
            $datas = AllStudent::with('foreignStudent')->get()->toArray();
            // dd($datas);
            foreach( $datas as $data){
                //  dd($data);
                if(!($data['foreign_student'] == null)){
                    $students[] = $data['foreign_student'];
                }

            }

              return view('page.admin.index', compact('students'));
        }

      
    }

    protected function create(){
        $next_id = LocalStudent::max('id_number') > ForeignStudent::max('id_number') ?
        LocalStudent::max('id_number') : ForeignStudent::max('id_number');
       
        return view('page.admin.create', compact('next_id'));
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

    protected function edit($student_type, $id){
        // dd($student_type);
        if($student_type == 'local'){
           $student = LocalStudent::findOrFail($id);
            return view('page.admin.edit', compact('student'));
        }
        if($student_type == 'foreign'){
            $student = ForeignStudent::findOrFail($id);
            return view('page.admin.edit', compact('student'));
        }
    }

    protected function update(UpdateStudentInformation $request, $id){
        // dd($request->old_student_type);
        $info = $request->request;
        $old_student_type = request()->old_student_type;
        $student_type = request()->student_type;
      
        // switching student type
        if(!($old_student_type == $student_type)){
            // dd($old_student_type, $student_type);
            // delete the record from the table 
             $this->destroy($old_student_type, $id);
            // create another record from the other table
            if($student_type == 'local'){
                $status =  $this->saveStudent($info, $student = new LocalStudent, $student_type);
                // dd($status);   
                return $status ? redirect()->route('student.index')->with('store', 'Success') : 
                                    back()->with('store', 'failed')->with('store', 'failed');
            }
            if($student_type == 'foreign'){
                $status = $this->saveStudent($info, $student = new ForeignStudent, $student_type); 
                return $status ? redirect()->route('student.index')->with('store', 'Success') : 
                                    back()->with('store', 'failed')->with('store', 'failed');
            }
              
        }else{
             $student_type == 'local' ? $status = $this->updateStudent($student = new LocalStudent, $id, $info) :
                                    $status = $status =$this->updateStudent($student = new ForeignStudent, $id, $info);
            
            return $status ? redirect()->route('student.index')->with('store', 'Success') : 
                    back()->with('store', 'failed')->with('store', 'failed');
        }
    }
      
    protected function destroy($student_type, $id){
        // check where table to delete
        $student_type == 'local' ? LocalStudent::findOrFail($id)->delete() : ForeignStudent::findOrFail($id)->delete();
        return back();
    }
      
    protected function saveStudent($request, Model $model, $student_type){
          // dd($request);
        $request = $request->all();
        $m = new $model;
        $m =  $m::create($request);
      
        $m::findOrFail($m->id);
        $student = new AllStudent();
        $student->student_type = $student_type;
      
        $student_type == 'local' ?  $student->local_student_id =  $m->id :
                                    $student->foreign_student_id =  $m->id;
      
        if($student->save()){
            return true;
        }else{
            return false;
        }
                
    }      
      
      protected function updateStudent(Model $model, $id, $obj){
        $arr = (array)$obj;
        $collapse = Arr::collapse($arr);
        $filtered = Arr::except($collapse, ['_token', '_method', 'old_id_number']);

        $status = $model::find($id)->update($filtered);
        return $status;
    }
}    
      