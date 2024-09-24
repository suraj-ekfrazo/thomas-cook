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


Route::group(
    [
        'middleware' => 'web',
        'prefix' => 'admin-incident-requests',
    ],
    function () {
        Route::get('/', 'AdminIncidentRequestController@index')->name('admin-incident-requests.index');
        Route::post('table-json', 'AdminIncidentRequestController@tableData')->name('admin-incident-requests.data');
        Route::get('/documents/{id}', 'AdminIncidentRequestController@getDocumentList')->name('admin-incident-requests.getDocumentList');
	//Export table
        Route::post('export-report', 'AdminIncidentRequestController@tableDataExport')->name('admin-incident-requests.export');
    }
);
