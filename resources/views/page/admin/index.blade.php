@extends('layout.layout')

@section('links')
@endsection

@section('content')
    <div class="w-full h-full px-[5%] pt-[100px]">
        <div class="overflow-hidden border-1 border-slate-500 rounded-box  p-3 shadow-md">
            <div class="commands flex gap-5">
                <a href="{{ route('student.create') }}" class="btn btn-success m-2">Add Students</a>
                <form action="{{ route('student.index', $request->filter_by ?? '') }}" method="post">
                  @csrf
                  <label for="filter">Filter By : 
                    <select name="filter_by" id="filter_by" >
                        <option value="all" {{ old('student_type') == 'all' ? '' : 'selected'}}></option>
                        <option value="local_students" 
                            {{ old('filter_by') == 'local' ? 'selected' : ''}}>Local</option>
                        <option value="foreign_students" 
                            {{ old('filter_by') == 'foreign' ? 'selected' : ''}}>Foreign</option>
                    </select>
                    <button type="submit">filt</button>
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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php $n = 1 @endphp
                @foreach ($students as $student)
                  <tr class="hover:bg-neutral-700 hover:text-white text-black">
                    <th>{{ $n }}</th>
                    <td>{{ $student['student_type']}}</td>
                    <td>{{ $student['id_number']}} </td>
                    <td>{{ $student['name']}}</td>
                    <td>{{ $student['age']}}</td>
                    <td>{{ $student['gender']}}</td>
                    <td>{{ $student['city']}}</td>
                    <td>{{ $student['email']}}</td>
                    <td>{{ $student['mobile_number']}}</td>
                    <td>{{ $student['grades']}}</td>
                    <td class="flex gap-4 p-4"><a href="{{ route('student.edit', $student['id'] ) }}" class="btn">Edit</a> <button type="button" class="btn">del</button></td>
                  </tr>
                  @php $n++ @endphp
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
@endsection