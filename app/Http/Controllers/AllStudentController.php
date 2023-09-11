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

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index(Request $filter_by){
        $filter_by->filter_by == null ?
                $filter = 'all' : $filter = $filter_by->filter_by;
        $this->datas = AllStudent::with(['localStudent', 'foreignStudent'])
                                    ->latest()->get()->toArray();
        $students = [];
        // dd($this->datas);
        if($filter == 'all'){
            foreach( $this->datas as $data ){
                $students[] = $data['local_student'] ?? $data['foreign_student'];
            }
        }

        if($filter == 'local_only'){
            foreach( $this->datas as $data){
               if(!($data['local_student'] == null)){
                    $students[] = $data['local_student'];
                }
            }
        }

        if($filter == 'foreign_only'){
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
        $next_id = LocalStudent::max('id_number') > ForeignStudent::max('id_number') ?
        LocalStudent::max('id_number') : ForeignStudent::max('id_number');

        return view('page.admin.create', compact('next_id'));
    }

    protected function store(StudentInformation $request){
       $this->notif_title = 'Student Succesfully Enrolled';

        $request->student_type === "foreign" ?
                $this->status = $this->saveStudent($request, $student = new ForeignStudent, $request->student_type) :
                $this->status = $this->saveStudent($request, $student = new LocalStudent, $request->student_type);

        if(!$this->status){
            $this->notif_title = 'Student Failed to Enrolled';
            $this->notif_status = 'Failed';
        }

        toast($this->notif_title, $this->notif_status);
        return back();
    }

    // protected function show(){

    // }

    protected function edit($student_type, $id){
        $student;
        $student_type == 'local' ?
           $student = LocalStudent::findOrFail($id) :
            $student = ForeignStudent::findOrFail($id);

        return view('page.admin.edit', compact('student'));
    }

    protected function update(StudentInformation $request, $id){
        $this->notif_title = 'Student Succesfully Updated';
        $this->method = request()->method();
        $info = $request->request;
        $old_student_type = request()->old_student_type;
        $student_type = request()->student_type;
        // switching student type
        if(!($old_student_type == $student_type)){
            // delete the record from the table
             $this->destroy($old_student_type, $id);
            // create another record from the other table
            $student_type == 'local' ?
                $this->status = $this->saveStudent($info, new LocalStudent, $student_type) :
                $this->status = $this->saveStudent($info, new ForeignStudent, $student_type);

            if(!$this->status){
                $this->notif_title = 'Student Failed to Update';
                $this->notif_status = 'Failed';
            }

        }else{
             $student_type == 'local' ?
                    $this->status = $this->updateStudent(new LocalStudent, $id, $info) :
                    $this->status = $this->updateStudent(new ForeignStudent, $id, $info);

        }

        toast($this->notif_title, $this->notif_status);
        return redirect()->route('student.index');
    }

    protected function destroy($student_type, $id){
        // need validation due to reuse
        if(!$this->method == 'PUT') $this->notif_title = 'Student Record Deleted';
        // check where table to delete
        if($student_type == 'local'){
            $exist = $this->lookThen(new LocalStudent, $id);
            $exist ? $this->status = LocalStudent::find($id)->delete():
                    $this->status = false;
        }else{
            $exist = $this->lookThen(new ForeignStudent, $id);
            $exist ? $this->status = ForeignStudent::find($id)->delete():
                    $this->status = false;
        }

        if(!$this->status){
            $this->notif_title = 'Student Not Exist';
            $this->notif_status = 'Failed';
        }

        toast($this->notif_title, $this->notif_status);
        return back();
    }

    protected function lookThen(Model $model, $id){
        $exist = true;
            try{
                $model::findOrFail($id);
            }catch(ModelNotFoundException $er){
                $exist = false;
            }
        return $exist;
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
