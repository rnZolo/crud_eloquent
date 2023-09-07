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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function(){
    Route::post('student', 'AllStudentController@store')->name('student.store');
    Route::get('student/{type?}', 'AllStudentController@index')->name('student.index');
    Route::get('student/create', 'AllStudentController@create')->name('student.create');
    Route::get('student/{id}/edit', 'AllStudentController@edit')->name('student.edit');
    Route::put('student/{id}', 'AllStudentController@update')->name('student.update');
});

// Route::resource('sample', 'SampleController');