@extends('layout.layout')

@section('links')
@endsection

@section('notif')
    @if(session('store'))
    <span class="txt-lg font-bold text-black">{{ session('store') }}</span>
    @endif
@endsection

@section('content')
    <div class="w-full h-full px-[5%] py-[100px]">
        <div class="overflow-hidden border-1 border-slate-500 rounded-box  p-3 shadow-md">
            <div class="commands flex gap-8">
                <a href="{{ route('student.create') }}" class="btn bg-green-700 hover:bg-green-400 m-2 text-white i bi-person-fill-add">
                    Add Students
                </a>
                <form action="{{ route('student.index'),  request()->filter_by }}" method="GET" class="flex justify-center items-center min-w-[50px]">
                  @csrf
                  <label for="filter" class="">Filter By : 
                    <select name="filter_by" id="filter_by" class="filterby ">
                        <option value="all" {{ request()->filter_by == 'all' ? '' : 'selected'}}>All</option>
                        <option value="local_only" 
                            {{ request()->filter_by == 'local_only' ? 'selected' : ''}}>Local</option>
                        <option value="foreign_only" 
                            {{ request()->filter_by == 'foreign_only' ? 'selected' : ''}}>Foreign</option>
                    </select>
                  </label>
                    <button type="submit" class="btn bg-green-700 hover:bg-green-400 text-white  ml-4 btn-sm text-[14px] bi bi-funnel-fill">
                      filter
                    </button>
                </form>
              </div>
            <table class="table">
              <!-- head -->
              <thead class="bg-neutral-700 text-white">
                <tr>
                  <th></th>
                  <th>Studend Type</th>
                  <th>ID Number</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>City</th>
                  <th>Mobile Number</th>
                  <th>Email</th>
                  <th>Grades</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $n = 1 @endphp
                {{-- {{ dd($students) }} --}}
                @foreach ($students as $student)
                  <tr class="hover:bg-neutral-700 hover:text-white text-black">
                    <th>{{ $n }}</th>
                    <td>{{ ucFirst($student['student_type'])}}</td>
                    <td>{{ $student['id_number'] }} </td>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['age'] }}</td>
                    <td>{{ $student['gender'] }}</td>
                    <td>{{ ucFirst($student['city']) }}</td>
                    <td>{{ $student['email'] }}</td>
                    <td>{{ $student['mobile_number'] }}</td>
                    <td>{{ $student['grades'] }}</td>
                    <td class="flex gap-4 p-4 justify-center">
                      <a href="{{ route('student.edit', [ "student_type" => $student['student_type'], "id" => $student['id']])}}" 
                        class="btn bg-blue-700 hover:bg-blue-400 text-white">
                        <i class="bi bi-pencil-fill"></i>
                        Edit</a>
                      <form action="{{ route('student.destroy', [ "student_type" => 
                        $student['student_type'], "id" => $student['id']])}}" method="post">
                        @csrf
                        @method('DELETE')
                      <button type="submit" class="btn btn-error bg-red-700 text-white">
                        <i class="bi bi-trash-fill"></i>
                        delete
                      </button>
                      </form>
                    </td>
                  </tr>
                  @php $n++ @endphp
                @endforeach
              </tbody>
            </table>  
          </div>
    </div>
@endsection





