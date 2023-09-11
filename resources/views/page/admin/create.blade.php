@extends('layouts.app')

@section('content')
    <div class="w-full h-full px-[5%] relative">
        <div class="overflow-hidden border-1 border-slate-500 shadow-lg shadow-black-500 px-[5%] py-[50px]">
            <form action="{{ route('student.store') }}" method="POST" class="add-stud-form flex flex-col gap-8">
                @csrf
                <div class="flex w-full gap-8">
                    <div class="flex flex-col max-w-50%[] w-full gap-5">
                        <label for="student_type">Student Type :
                            <select name="student_type" id="student_type"
                                class="@error('student_type') ring-2 ring-red-500 border-0 @enderror">
                                <option value="" {{ old('student_type') == null ? '' : 'selected' }}></option>
                                <option value="local" {{ old('student_type') == 'local' ? 'selected' : '' }}>Local</option>
                                <option value="foreign" {{ old('student_type') == 'foreign' ? 'selected' : '' }}>Foreign
                                </option>
                            </select>
                            @error('student_type')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="id_number">ID Number :
                            <input type="text" name="id_number" id="id_number"
                                value="{{ old('id_number')}}"
                                class="@error('id_number') border-2 border-red-500 @enderror">
                            @error('id_number')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="name">Name :
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="@error('name') border-2 border-red-500 @enderror">
                            @error('name')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="age">Age :
                            <input type="text" name="age" id="age" value="{{ old('age') }}"
                                class="@error('age') border-2 border-red-500 @enderror">
                            @error('age')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="gender">Gender :
                            <select name="gender" id="gender"
                                class="@error('gender') ring-2 ring-red-500 border-0 @enderror">
                                <option value="" {{ old('gender') == null ? '' : 'selected' }}></option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
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
                            <input type="text" name="city" id="city" value="{{ old('city') }}"
                                class="@error('city') border-2 border-red-500 @enderror">
                            @error('city')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="mobile_number">Mobile Number :
                            <input type="text" name="mobile_number" id="mobile_number"
                                value="{{ old('mobile_number') }}"
                                class="@error('mobile_number') border-2 border-red-500 @enderror">
                            @error('mobile_number')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="email">E-mail :
                            <input type="text" name="email" id="email" value="{{ old('email') }}"
                                class="@error('email') border-2 border-red-500 @enderror">
                            @error('email')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                        <label for="grades">Grades :
                            <input type="text" name="grades" id="grades" value="{{ old('grades') }}"
                                class="@error('grades') border-2 border-red-500 @enderror">
                            @error('grades')
                                <span class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn bg-green-700 hover:bg-green-400 text-white ml-auto">Create
                    Student</button>
            </form>
        </div>
    </div>
@endsection
