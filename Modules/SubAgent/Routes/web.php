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

Route::prefix('subagent')->group(function () {
    Route::get('/', 'SubAgentController@index')->name('subagent.index');
    Route::post('table-json', 'SubAgentController@tableData')->name('subagent.data');
    Route::get('create', 'SubAgentController@create')->name('subagent.add');
    Route::post('save', 'SubAgentController@store')->name('subagent.save');
    Route::get('edit/{id}', 'SubAgentController@edit')->name('subagent.edit');
    Route::post('update', 'SubAgentController@update')->name('subagent.update');
    Route::delete('delete/{id}', 'SubAgentController@destroy')->name('subagent.destroy');
    Route::get('update-status', 'SubAgentController@updateStatus')->name('subagent.update-status');
    Route::get('get-agent-data', 'SubAgentController@getAgentData')->name('subagent.get-agent-data');
	 Route::get('subagent_export', 'SubAgentController@export')->name('subagent_export');
});
