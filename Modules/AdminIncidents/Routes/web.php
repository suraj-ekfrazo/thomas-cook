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
        'prefix' => 'admin-incidents',
    ],
    function () {
        Route::get('/', 'AdminIncidentsController@index')->name('admin-incidents.index');
        Route::post('table-json', 'AdminIncidentsController@tableData')->name('admin-incidents.data');
        Route::post('export-report', 'AdminIncidentsController@tableDataExport')->name('admin-incidents.export');
        Route::post('export-buy-report', 'AdminIncidentsController@tableBuyDataExport')->name('admin-incidents.export-buy-report');
        Route::post('export-sell-report', 'AdminIncidentsController@tableSellDataExport')->name('admin-incidents.export-sell-report');
        Route::post('export-tc-user-report', 'AdminIncidentsController@tableTcUserDataExport')->name('admin-incidents.export-tc-user-report');
        Route::post('export-agent-report', 'AdminIncidentsController@tableAgentDataExport')->name('admin-incidents.export-agent-report');
        // UnAssigned incidents
        Route::get('/unassigned', 'AdminIncidentsController@unassigned')->name('admin-incidents.unassigned');
        Route::post('table-json-unassigned', 'AdminIncidentsController@tableDataUnassigned')->name('admin-incidents.tableDataUnassigned');
        Route::get('get-incident-details', 'AdminIncidentsController@getIncidentDetails')->name('admin-incidents.getIncidentDetails');

        //Summary report
        Route::get('/report-summary', 'AdminIncidentsController@reportSummary')->name('admin-incidents.report-summary');
        Route::get('/report-summary-table', 'AdminIncidentsController@reportSummaryTable')->name('admin-incidents.report-summary-table');
        //Buy report
        Route::get('/view-buy-report', 'AdminIncidentsController@viewBuyReport')->name('admin-incidents.view-buy-report');
        Route::post('buy-report', 'AdminIncidentsController@buyReport')->name('admin-incidents.buy-report');
        //Sell report
        Route::get('/view-sell-report', 'AdminIncidentsController@viewSellReport')->name('admin-incidents.view-sell-report');
        Route::post('sell-report', 'AdminIncidentsController@sellReport')->name('admin-incidents.sell-report');
        //Tc User report
        Route::get('/view-tcuser-report', 'AdminIncidentsController@viewTcUserReport')->name('admin-incidents.view-tcuser-report');
        Route::post('tcuser-report', 'AdminIncidentsController@tcUserReport')->name('admin-incidents.tcuser-report');
        //Agent report
        Route::get('/view-agent-report', 'AdminIncidentsController@viewAgentReport')->name('admin-incidents.view-agent-report');
        Route::post('agent-report', 'AdminIncidentsController@agentReport')->name('admin-incidents.agent-report');
	
	//Tc User Summary report
        Route::get('/view-tcuser-summary-report', 'AdminIncidentsController@viewTcUserSummaryReport')->name('admin-incidents.view-tcuser-summary-report');
        Route::post('tcuser-summary-report', 'AdminIncidentsController@tcUserSummaryReport')->name('admin-incidents.tcuser-summary-report');
    }
);
