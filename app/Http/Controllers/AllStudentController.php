<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentInformation;
use App\Http\Requests\UpdateStudentInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    protected function index(Request $filter_by){
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

        $title = 'Delete Student!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('page.admin.index', compact('students'));
    }

    protected function create(){

        // $next_id = LocalStudent::max('id_number') > ForeignStudent::max('id_number') ?
        // LocalStudent::max('id_number') : ForeignStudent::max('id_number');, compact('next_id')

        return view('page.admin.create');
    }

    protected function store(StudentInformation $request){
       $this->notif_title = 'Student Succesfully Enrolled';

        $request->student_type === "foreign" ?
                $this->status = $this->saveStudent($request, new ForeignStudent, $request->student_type) :
                $this->status = $this->saveStudent($request, new LocalStudent, $request->student_type);

        if(!$this->status){
            $this->notif_title = 'Student Failed to Enrolled';
            $this->notif_status = 'error';
        }

        toast($this->notif_title, $this->notif_status);
        return back();
    }

    protected function edit($student_type, $id){
        $student;
        $student_type == 'local' ?
           $this->status = $this->notFound(new LocalStudent, $id) :
            $this->status = $this->notFound(new ForeignStudent, $id);

        if(!$this->status){
            toast($this->notif_title, $this->notif_status);
            return back();
        }

        $student_type == 'local' ?
           $student = LocalStudent::find($id) :
            $student = ForeignStudent::find($id);

        return view('page.admin.edit', compact('student'));
    }

    protected function update(StudentInformation $request, $id){
        $this->notif_title = 'Student Succesfully Updated';
        $this->method = request()->method();
        $info = $request->request;
        $old_student_type = request()->old_student_type;
        $student_type = request()->student_type;
        $old_student_type == 'local' ? 
                            $exist = $this->notFound(new LocalStudent, $id) :
                            $exist = $this->notFound(new ForeignStudent, $id);

        if(!$exist){
            toast($this->notif_title, $this->notif_status);
            return back();
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

        if(!$this->status){
            $this->notif_title = 'Student Failed to Update';
            $this->notif_status = 'error';
        }

        toast($this->notif_title, $this->notif_status);
        return redirect()->route('student.index');
    }

    protected function destroy($student_type, $id){
        // need validation due to reuse
        if(!$this->method == 'PUT') $this->notif_title = 'Student Record Deleted';
        // check where table to delete
        if($student_type == 'local'){
            $exist = $this->notFound(new LocalStudent, $id);
            if($exist) $this->status = LocalStudent::find($id)->delete();

        }else{
            $exist = $this->notFound(new ForeignStudent, $id);
            if($exist) $this->status = ForeignStudent::find($id)->delete();

        }

        toast($this->notif_title, $this->notif_status);
        return back();
    }

    protected function notFound(Model $model, $id){

            try{
                $model::findOrFail($id);
                // $u = $model::find($id); // working null if not found then work around to handle not found response
            }catch(ModelNotFoundException $er){
                $this->notif_title = 'Student Record Not Found';
                $this->notif_status = 'error';
                return false;
            }
        return true;
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
