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

Route::prefix('subadmin')->group(function () {
    Route::get('/', 'SubAdminController@index')->name('subadmin.index');
    Route::post('table-json', 'SubAdminController@tableData')->name('subadmin.data');
    Route::get('create', 'SubAdminController@create')->name('subadmin.add');
    Route::post('save', 'SubAdminController@store')->name('subadmin.save');

    Route::get('edit/{id}', 'SubAdminController@edit')->name('subadmin.edit');
    Route::post('update', 'SubAdminController@update')->name('subadmin.update');
    Route::delete('delete/{id}', 'SubAdminController@destroy')->name('subadmin.destroy');
    Route::get('update-status', 'SubAdminController@updateStatus')->name('subadmin.update-status');
});
