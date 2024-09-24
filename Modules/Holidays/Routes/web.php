<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('holidays')->group(function() {
    Route::get('/', 'HolidaysController@index')->name('holidays.index');
    Route::post('table-json', 'HolidaysController@tableData')->name('holidays.data');
    Route::get('create', 'HolidaysController@create')->name('holidays.add');
    Route::post('save', 'HolidaysController@save')->name('holidays.save');
    Route::get('edit/{id}', 'HolidaysController@edit')->name('holidays.edit');
    Route::post('update', 'HolidaysController@update')->name('holidays.update');
    Route::delete('delete/{id}', 'HolidaysController@destroy')->name('holidays.destroy');
});
