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

Route::prefix('under-process-booking-request')->group(function () {
    Route::get('/', 'UnderProcessBookingRequestController@index')->name('under-process-request.index');
    Route::post('table-json', 'UnderProcessBookingRequestController@tableData')->name('under-process-request.data');
    Route::get('sell', 'UnderProcessBookingRequestController@dataSell')->name('under-process-request.sell');
    Route::post('table-json-sell', 'UnderProcessBookingRequestController@tableDataSell')->name('under-process-request.data-sell');
    //Export table
    Route::post('export-report', 'UnderProcessBookingRequestController@tableDataExport')->name('under-process-request.export');
    Route::post('export-sell-report', 'UnderProcessBookingRequestController@tablesellDataExport')->name('under-process-request.sellexport');
});
