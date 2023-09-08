@extends('layout.layout')

@section('notif')
    {{-- @if(session('store'))
    <span class="txt-lg font-bold text-black">{{ session('store') }}</span>
    @endif --}}
@endsection

@section('content')
    <div class="w-full h-full px-[5%] pt-[100px] relative">
        {{-- {{ dd($student )}} --}}
        <div class="overflow-hidden border-1 border-slate-500 shadow-lg shadow-black-500 px-[5%] py-[50px]">
            <form action="{{ route('student.update', ['id' => $student->id, 'old_id_number' => $student->id_number, 
                'old_student_type' => $student['student_type']]) }}" method="POST" class="add-stud-form flex flex-col gap-8">
                @csrf
                @method('PUT')
                <div class="flex w-full gap-8">
                    <div class="flex flex-col max-w-50%[] w-full gap-5">
                        <label for="student_type">Student Type :
                            <select name="student_type" id="student_type" >
                                <option value="local" 
                                    {{ $student['student_type'] == 'local' ? 'selected' : ''}}>Local</option>
                                <option value="foreign" 
                                    {{ $student['student_type'] == 'foreign' ? 'selected' : ''}}>Foreign</option>
                            </select>
                                @error('student_type')
                                    <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                        {{ $message }}
                                    </span>
                                @enderror
                        </label>
                        <label for="id_number">ID Number : 
                            <input type="text" name="id_number" id="id_number" value="{{ $student['id_number'] }}">
                            @error('id_number')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="name">Name : 
                            <input type="text" name="name" id="name" value="{{  $student['name'] }}">
                            @error('name')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="age">Age : 
                            <input type="text" name="age" id="age" value="{{ $student['age'] }}">
                            @error('age')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="gender">Gender : 
                            <select  name="gender" id="gender">
                                <option value="male" 
                                {{ $student['gender'] == 'male' ? 'selected' : ''}}>Male</option>
                                <option value="female" 
                                {{ $student['gender'] == 'female' ? 'selected' : ''}}>Female</option>
                            </select>
                            @error('gender')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                    </div>
                    <div class="flex flex-col max-w-50%[] w-full gap-5">
                        <label for="city">City : 
                            <input type="text" name="city" id="city" value="{{ $student['city'] }}">
                            @error('city')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="mobile_number">Mobile Number : 
                            <input type="text" name="mobile_number" id="mobile_number" value="{{ $student['mobile_number'] }}">
                            @error('mobile_number')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="email">Email : 
                            <input type="text" name="email" id="email" value="{{ $student['email'] }}">
                            @error('email')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="grades">Grades : 
                            <input type="text" name="grades" id="grades" value="{{ $student['grades'] }}">
                            @error('grades')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn bg-blue-700 hover:bg-blue-400 text-white ml-auto">Apply Changes</button>
            </form>
        </div>
    </div>
@endsection