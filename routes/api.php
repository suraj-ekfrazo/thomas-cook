<?php

use App\Http\Controllers\api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', 'HomeController@user');
Route::post('buylist', 'IncidantController@Buylist');
Route::post('selllist', 'IncidantController@Selllist');
Route::post('receivedocstatus', 'IncidantController@receivestatus');
Route::post('currency-data', 'CurrencyController@store');
Route::get('expired-incidents', 'ApiController@expiredIncidents');
Route::get('buyCurrentRate', 'ApiController@buyCurrentRate');
Route::get('assignincident', 'ApiController@assignIncident');

Route::get('expirydate', [NotificationController::class,'expirydate'])->name('expirydate'); // Get expiry notification