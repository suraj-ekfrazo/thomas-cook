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

use Illuminate\Support\Facades\Route;

Route::prefix('tcuser')->group(function () {
    Route::get('/', 'TcUserController@index')->name('tcuser.index');
    Route::post('table-json', 'TcUserController@tableData')->name('tcuser.data');
    Route::get('create', 'TcUserController@create')->name('tcuser.add');
    Route::post('save', 'TcUserController@store')->name('tcuser.save');
    Route::post('name', 'TcUserController@checkName')->name('name.post');
	 Route::get('export', 'TcUserController@export')->name('export');
   

    Route::get('edit/{id}', 'TcUserController@edit')->name('tcuser.edit');
    Route::post('update', 'TcUserController@update')->name('tcuser.update');
    Route::delete('delete/{id}', 'TcUserController@destroy')->name('tcuser.destroy');
    Route::get('update-status', 'TcUserController@updateStatus')->name('tcuser.update-status');
});
