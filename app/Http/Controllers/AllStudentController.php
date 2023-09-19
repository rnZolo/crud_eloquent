<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentInformation;
use App\Http\Requests\UpdateStudentInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;
use App\AllStudent;
use App\LocalStudent;
use App\ForeignStudent;



class AllStudentController extends Controller
{
    protected $notif_title;
    protected $notif_status = 'success';
    protected $status;
    protected $datas;
    protected $method;

    public function __construct(){
        $this->middleware('auth');
    }

    protected function index(){
        return view('page.admin.index');
    }

    function ajax(Request $filter_by){
        
        $filter_by->filter_by == null ?
                $filter = 'all' : $filter = $filter_by->filter_by;

        $students = [];
        if($filter == 'all'){
            $this->datas = AllStudent::with(['localStudent', 'foreignStudent']) 
                                                    ->latest()->get()->toArray();
            foreach( $this->datas as $data ){
                $students[] = $data['local_student'] ?? $data['foreign_student'];
            }
        }
       
        if($filter == 'local_only'){
            $this->datas = AllStudent::with(['localStudent'])->latest()->get()->toArray();
            foreach( $this->datas as $data){
               if(!($data['local_student'] == null)){
                    $students[] = $data['local_student'];
                }
            }
        }

        if($filter == 'foreign_only'){
            $this->datas = AllStudent::with(['foreignStudent'])->latest()->get()->toArray();
            foreach( $this->datas as $data){
                if(!($data['foreign_student'] == null)){
                    $students[] = $data['foreign_student'];
                }
            }
        }

        return datatables()->of($students)->toJson();
    }

    protected function create(){
        return view('page.admin.create');
    }
    
    protected function store(StudentInformation $request){

       $request->student_type === "foreign" ?
                $this->status = $this->saveStudent($request, new ForeignStudent, $request->student_type) :
                $this->status = $this->saveStudent($request, new LocalStudent, $request->student_type);

        if(!$this->status[0]){
            return response()->json('Student Failed to Enrolled', 400);
        }

        return response()->json($request, 200);
    }

    protected function edit($student_type, $id){
      
        $student;
        $student_type == 'local' ?
           $this->status = $this->notFound(new LocalStudent, $id) :
            $this->status = $this->notFound(new ForeignStudent, $id);

        if(!$this->status[0]){
            return response()->json(['message' => 'Student not Found'], 400);

        }

        $student_type == 'local' ?
            $student = LocalStudent::find($id) :
            $student = ForeignStudent::find($id);

        return response()->json($student, 200);
    }

    protected function update(StudentInformation $request, $id){
       
        $this->method = request()->method();
        $info = $request->request;
        $old_student_type = request()->old_student_type;
        $student_type = request()->student_type;
        
        $old_student_type == 'local' ? 
                            $exist = $this->notFound(new LocalStudent, $id) :
                            $exist = $this->notFound(new ForeignStudent, $id);

        if(!$exist){
            return response()->json('Update Failed, Student not Exist', 400);
        }
       
        // switching student type
        if(!($old_student_type == $student_type)){
            // delete the record from the table
            $this->destroy($old_student_type, $id);
            // create another record from the other table
            $student_type == 'local' ?
                $this->status = $this->saveStudent($info, new LocalStudent, $student_type) :
                $this->status = $this->saveStudent($info, new ForeignStudent, $student_type);

        }else{
             $student_type == 'local' ?
                    $this->status = $this->updateStudent(new LocalStudent, $id, $info) :
                    $this->status = $this->updateStudent(new ForeignStudent, $id, $info);
        }

        if(!$this->status[0]){
            return response()->json('Failed to Update', 400);
        }

        return response()->json(['message' => 'Student Successfully Updated',
                                 'status' => 200, 'id' => $this->status[1]]);
    }

    protected function destroy($student_type, $id){

        // check where table to delete
        if($student_type == 'local'){
            $exist = $this->notFound(new LocalStudent, $id);
           if ($exist){
                $this->status = LocalStudent::find($id)->delete();
            }else{
                return response()->json('Failed to Delete', 400);
            }      
        }else{
            $exist = $this->notFound(new ForeignStudent, $id);
            if($exist){ 
                $this->status = ForeignStudent::find($id)->delete();
            }else{
                return response()->json('Failed to Delete', 400);
            }
        }

        if(!$this->method == 'PUT') return response()->json('Succesfully Deleted', 200);
    }

    protected function multiDestroy(Request $request){
        $id_numbers = request()->id_numbers;  

        if(!(count($id_numbers) < 1)){
            LocalStudent::whereIn('id_number',  $id_numbers)->delete();
            ForeignStudent::whereIn('id_number',  $id_numbers)->delete();
            return response()->json('Delete success.', 200);
        }
        
        return response()->json('Perform a Single Delete.', 400);
    }

    protected function notFound(Model $model, $id){
            try{
                $model::findOrFail($id);
            }catch(ModelNotFoundException $er){
                return [ false, $id];
            }
        return [true , $id];
    }

    protected function saveStudent($request, Model $model, $student_type){
        $request = $request->all();
        $m = new $model;
        $m =  $m::create($request);

        $student = new AllStudent();
        $student->student_type = $student_type;

        $student_type == 'local' ?  $student->local_student_id =  $m->id :
                                    $student->foreign_student_id =  $m->id;

        if($student->save()){
            return [true, $m->id];
        }else{
            return [false, $m->id];
        }

    }

      protected function updateStudent(Model $model, $id, $obj){
        $arr = (array)$obj;
        $collapse = Arr::collapse($arr);
        $filtered = Arr::except($collapse, ['_token', '_method', 'old_id_number']);

        $status = $model::find($id)->update($filtered);
        return [$status, $id];
    }
}
