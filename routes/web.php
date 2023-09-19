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
Route::redirect('/', 'admin/student', 302);
Auth::routes();
Route::prefix('admin')->group(function(){
    Route::put('student/{id}', 'AllStudentController@update')->name('student.update');
    Route::delete('student/delete_selected', 'AllStudentController@multiDestroy')->name('student.multi.destroy');
    Route::delete('student/{student_type}_{id}', 'AllStudentController@destroy')->name('student.destroy');
    Route::get('student/create', 'AllStudentController@create')->name('student.create');
    Route::get('ajax', 'AllStudentController@ajax')->name('student.ajax');
    Route::get('student', 'AllStudentController@index')->name('student.index');
    Route::post('student', 'AllStudentController@store')->name('student.store');
    Route::get('student/{student_type}_{id}/edit', 'AllStudentController@edit')->name('student.edit');
});

Route::group(['prefix' => 'product/', 'as' => 'item.'], function(){
    Route::delete('item/{id}/destroy', 'ItemController@destroy')->name('destroy');
    Route::get('ajx', 'ItemController@ajx')->name('ajx');
    Route::get('item', 'ItemController@index')->name('index');
    Route::get('item/{id}/edit', 'ItemController@edit')->name('edit');
    Route::post('item/store', 'ItemController@store')->name('store');
});


Route::fallback('AllStudentController@index');
// Route::resource('sample', 'SampleController');
