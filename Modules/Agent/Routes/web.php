<?php

use Illuminate\Support\Facades\Route;

Route::prefix('agent')->group(function () {
    Route::get('/', 'AgentController@index')->name('agent.index');
    Route::post('table-json', 'AgentController@tableData')->name('agent.data');
    Route::get('create', 'AgentController@create')->name('agent.add');
     Route::get('importView', 'AgentController@importView')->name('agent.importView');
    Route::post('import', 'AgentController@import')->name('agent.import');
    Route::post('save', 'AgentController@save')->name('agent.save');
    Route::get('show/{id}', 'AgentController@show')->name('agent.show');
    Route::get('edit/{id}', 'AgentController@edit')->name('agent.edit');
    Route::post('update', 'AgentController@update')->name('agent.update');
    Route::delete('delete/{id}', 'AgentController@destroy')->name('agent.destroy');
    Route::get('update-status', 'AgentController@updateStatus')->name('agent.update-status');
    Route::post('agentname', 'AgentController@checkAgentName')->name('agentname.post');
	Route::get('export', 'AgentController@export')->name('export.tcuser');

    // admin-users.deleted.index
    Route::get('/deleted', 'AgentDeletedController@index')->name('agent.deleted.index');
    Route::post('deleted-table-json', 'AgentDeletedController@tableData')->name('agent.deleted.data');
    Route::get('show-deleted/{id}', 'AgentDeletedController@show')->name('agent.deleted.show');
    Route::get('reactive/{id}', 'AgentDeletedController@reactive')->name('agent.deleted.reactive');
});
