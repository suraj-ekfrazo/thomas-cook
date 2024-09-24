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

Route::prefix('admin-users')->group(function () {
    Route::get('/', 'AdminUsersController@index')->name('admin-users.index');
    Route::post('table-json', 'AdminUsersController@tableData')->name('admin-users.data');
    Route::get('create', 'AdminUsersController@create')->name('admin-users.add');
    Route::post('save', 'AdminUsersController@save')->name('admin-users.save');
    Route::get('show/{id}', 'AdminUsersController@show')->name('admin-users.show');
    Route::get('edit/{id}', 'AdminUsersController@edit')->name('admin-users.edit');
    Route::post('update', 'AdminUsersController@update')->name('admin-users.update');
    Route::delete('delete/{id}', 'AdminUsersController@destroy')->name('admin-users.destroy');
    Route::get('update-status', 'AdminUsersController@updateStatus')->name('admin-users.update-status');

    // Deleted admin users
    Route::get('/deleted', 'AdminUsersDeletedController@index')->name('admin-users.deleted.index');
    Route::post('deleted-table-json', 'AdminUsersDeletedController@tableData')->name('admin-users.deleted.data');
    Route::get('show-deleted/{id}', 'AdminUsersDeletedController@show')->name('admin-users.deleted.show');
    Route::get('reactive/{id}', 'AdminUsersDeletedController@reactive')->name('admin-users.deleted.reactive');
});
