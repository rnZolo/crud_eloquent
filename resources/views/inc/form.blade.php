<span class="bi bi-x-circle-fill text-lg absolute top-[13px] right-[13px]" id="modal-close-btn"></span>
<div class="flex w-full gap-8 bg-white relative">
    <div class="flex flex-col max-w-50%[] w-full gap-5">
        <label for="student_type">Student Type :
            <select name="student_type" id="student_type">
                <option value="" ></option>
                <option value="local" >Local</option>
                <option value="foreign">Foreign
                </option>
            </select>
            <span id="err_student_type" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
        </label>
        <label for="id_number">ID Number :
            <input type="text" name="id_number" id="id_number"
                value="">
                <span id="err_id_number" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
        <label for="name">Name :
            <input type="text" name="name" id="name" value="">
                <span id="err_name" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
        <label for="age">Age :
            <input type="text" name="age" id="age" value="">
                <span id="err_age" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
        <label for="gender">Gender :
            <select name="gender" id="gender">
                <option value=""></option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
                <span id="err_gender" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
    </div>
    <div class="flex flex-col max-w-50%[] w-full gap-5">
        <label for="city">City :
            <input type="text" name="city" id="city" value="">
                <span id="err_city" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
        <label for="mobile_number">Mobile Number :
            <input type="text" name="mobile_number" id="mobile_number"
                value="">
                <span id="err_mobile_number" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
        <label for="email">E-mail :
            <input type="text" name="email" id="email" value="">
                <span id="err_email" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
        <label for="grades">Grades :
            <input type="text" name="grades" id="grades" value="">
                <span id="err_grades" class="text-[13px] m-0 p-0 font-bold text-red-500 absolute -bottom-6 left-0">
                </span>
        </label>
    </div>
</div>
<button class="btn bg-blue-700 hover:bg-blue-400 text-white ml-auto " id="submit_stud">Create Student</button>
{{-- <button type="submit" class="btn bg-green-700 hover:bg-green-400 text-white ml-auto">Create Student</button> --}}