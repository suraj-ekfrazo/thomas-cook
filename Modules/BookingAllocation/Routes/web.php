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

Route::prefix('booking-allocation')->group(function () {
    Route::get('/', 'BookingAllocationController@index')->name('booking-allocation');
    Route::post('table-json', 'BookingAllocationController@tableData')->name('booking-allocation.data');
    Route::post('update-assigned-user', 'BookingAllocationController@updateAssignedUser')->name('booking-allocation.update-assigned-user');
});
