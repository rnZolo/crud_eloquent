<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::prefix('admin')->group(function(){
    Route::get('student/create', 'AllStudentController@create')->name('student.create');
    Route::get('student', 'AllStudentController@index')->name('student.index');
    Route::post('student', 'AllStudentController@store')->name('student.store');
    Route::delete('student/{student_type}_{id}', 'AllStudentController@destroy')->name('student.destroy');
    Route::put('student/{id}', 'AllStudentController@update')->name('student.update');
    Route::get('student/{student_type}-{id}/edit', 'AllStudentController@edit')->name('student.edit');
});

Route::fallback('AllStudentController@index');
// Route::resource('sample', 'SampleController');
