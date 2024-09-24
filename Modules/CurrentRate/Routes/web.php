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

Route::prefix('currentrate')->group(function() {
    Route::get('/', 'CurrentRateController@index')->name('currentrate');
    Route::post('table-json', 'CurrentRateController@tableData')->name('currentrate.data');
    Route::get('edit/{id}', 'CurrentRateController@edit')->name('currentrate.edit');
    Route::post('update', 'CurrentRateController@update')->name('currentrate.update');

});
