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

Route::prefix('historybackup')->group(function () {
    Route::get('/', 'HistoryBackupController@index')->name('history-backup.index');
    Route::get('create', 'HistoryBackupController@create')->name('history-backup.create');
    Route::get('table-json', 'HistoryBackupController@tableData')->name('history-backup.data');
});
