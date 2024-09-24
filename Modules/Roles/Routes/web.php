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

Route::prefix('roles')->group(function() {
    Route::get('/', 'RolesController@index')->name('roles.index');
    Route::post('table-json', 'RolesController@tableData')->name('roles.data');
    Route::get('create', 'RolesController@create')->name('roles.add');
    Route::post('save', 'RolesController@save')->name('roles.save');
    Route::get('show/{id}', 'RolesController@show')->name('roles.show');
    Route::get('edit/{id}', 'RolesController@edit')->name('roles.edit');
    Route::post('update', 'RolesController@update')->name('roles.update');
    Route::delete('delete/{id}', 'RolesController@destroy')->name('roles.destroy');
});
