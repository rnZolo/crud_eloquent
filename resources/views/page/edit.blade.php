@extends('layout.layout')

@section('notif')
    {{-- @if(session('store'))
    <span class="txt-lg font-bold text-black">{{ session('store') }}</span>
    @endif --}}
@endsection

@section('content')
    <div class="w-full h-full px-[5%] pt-[100px] relative">
        <a href="{{ route('student.index') }}" 
            class="btn hover:bg-green-600 bg-green-500 text-white absolute top-5 left-5">
            Back
        </a>
        <div class="overflow-hidden border-1 border-slate-500 shadow-lg shadow-black-500 px-[5%] py-[50px]">
            <form action="{{ route('student.store')  }}" method="post" class="add-stud-form flex flex-col w-[80%] gap-8">
                @csrf
                <label for="student_type">Student Type : 
                    <select name="student_type" id="student_type" >
                        <option value="" {{ old('student_type') == null ? '' : 'selected'}}></option>
                        <option value="local" 
                            {{ old('student_type') == 'local' ? 'selected' : ''}}>Local</option>
                        <option value="foreign" 
                            {{ old('student_type') == 'foreign' ? 'selected' : ''}}>Foreign</option>
                    </select>
                        @error('student_type')
                            <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                {{ $message }}
                            </span>
                        @enderror
                </label>
                <label for="id_number">ID Number : 
                    <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}">
                    @error('id_number')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <label for="name">Name : 
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <label for="age">Age : 
                    <input type="text" name="age" id="age" value="{{ old('age') }}">
                @error('age')
                    <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                        {{ $message }}
                    </span>
                @enderror
                </label>
                <label for="gender">Gender : 
                    <select  name="gender" id="gender">
                        <option value="" 
                        {{ old('gender') == null ? '' : 'selected'}}></option>
                        <option value="male" 
                        {{ old('gender') == 'male' ? 'selected' : ''}}>Male</option>
                        <option value="female" 
                        {{ old('gender') == 'female' ? 'selected' : ''}}>Female</option>
                    </select>
                    @error('gender')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <label for="city">City : 
                    <input type="text" name="city" id="city" value="{{ old('city') }}">
                    @error('city')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <label for="mobile_number">Mobile Number : 
                    <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}">
                    @error('mobile_number')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <label for="email">Email : 
                    <input type="text" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <label for="grades">Grades : 
                    <input type="text" name="grades" id="grades" value="{{ old('grades') }}">
                    @error('grades')
                        <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
                <button type="submit" class="btn hover:bg-green-600 bg-green-500 text-white">Save Changes</button>
            </form>
        </div>
    </div>
@endsection