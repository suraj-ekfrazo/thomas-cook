<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordTCuserController;
  

Auth::routes();
// Route::get('/', [HomeController::class, 'index']);
Route::get('/', ['uses' => 'Auth\LoginController@home']);

Route::middleware('guest:admin')->group(function () {
    Route::get('/login/admin', ['uses' => 'Auth\LoginController@showAdminLoginForm']);
    Route::post('/login/admin', ['uses' => 'Auth\LoginController@adminLogin']);
});

Route::middleware('guest:agent')->group(function () {
    // Agent Login
    Route::get('/agent/login', ['uses' => 'Auth\LoginController@showEmployeeLoginForm', 'as' => 'employee.login']);
    Route::post('/agent/login', ['uses' => 'Auth\LoginController@employeeLogin']);
});


Route::group(['middleware' => 'auth:agent'], function () {
    Route::get('/agent/dashboard', ['uses' => 'AgentController@userDashboard', 'as' => 'employee.dashboard']);
    Route::post('/agent/incidentfrm', ['uses' => 'AgentController@incidentSave', 'as' => 'incident.save']);
    Route::post('incidentInsert', ['uses' => 'FrontController@incidentInsert', 'as' => 'incidentInsert']);
    Route::get('/agent/profile', ['uses' => 'AgentController@userProfile', 'as' => 'employee.profile']);
    // Update password
    Route::post('update-password', ['uses' => 'AgentController@updatePassword'])->name('user-password.update');
    // Notifications
    Route::get('notifications', ['uses' => 'NotificationController@index'])->name('notification.index');
    Route::get('show-notifications/{id}', ['uses' => 'NotificationController@show'])->name('notification.show');
    Route::get('agent-logout', ['uses' => 'AgentController@logout'])->name('agent.logout');
    Route::get('agent-view-upload-document', ['uses' => 'AgentController@viewUploadDocumentModal'])->name('agent-view-upload-document');
    Route::post('agent-upload-document', ['uses' => 'AgentController@uploadDocument'])->name('agent-upload-document');
    //Upload Rejected document
    Route::get('agent-view-rej-upload-doc', ['uses' => 'AgentController@viewRejectedUploadDocumentModal'])->name('agent-view-rej-upload-doc');
    Route::post('agent-upload-rejected-document', ['uses' => 'AgentController@uploadRejectedDocument'])->name('agent-upload-rejected-document');
    Route::post('agent-view-document', ['uses' => 'AgentController@viewDocument'])->name('agent-view-document');
});

Route::group(['middleware' => 'auth:admin'], function () {
    // Dashboard
    Route::get('dashboard', ['uses' => 'AdminController@index', 'as' => 'dashboard.index']);
    // Route::get('admin-list', ['uses' => 'AdminController@adminList', 'as' => 'admin-list']);
    // Route::get('create-admin', ['uses' => 'AdminController@create', 'as' => 'create-admin']);

    Route::resource('sub-admin', SubAdminController::class);
    Route::resource('tc-user', TcUserController::class);


    // Profile
    Route::post('update-profile', ['uses' => 'AdminController@updateProfile'])->name('admin-profile.update');
    Route::post('admin-logout', ['uses' => 'AdminController@logout'])->name('admin.logout');
});

Route::middleware('guest:tcuser')->group(function () {
    // Tc User Login
    Route::get('/tcuser/login', ['uses' => 'Auth\LoginController@showTcUserLoginForm', 'as' => 'tcuser.login']);
    Route::post('/tcuser/login', ['uses' => 'Auth\LoginController@tcUserLogin']);
});

//Tc user
Route::group(['middleware' => 'auth:tcuser'], function () {
    Route::get('/tcuser/dashboard', ['uses' => 'TcUserController@tcUserDashboard', 'as' => 'tcuser.dashboard']);
    Route::post('table-json-booking-request', ['uses' => 'TcUserController@bookingRequest'])->name('tcuser.bookingRequest');
    Route::get('tcuser-logout', ['uses' => 'TcUserController@logout'])->name('tcuser.logout');
    Route::get('tcuser-booking-request/{id}', ['uses' => 'TcUserController@viewBookingRquest'])->name('tcuser.booking-request');
    //update document
    Route::get('tcuser-update-document-status', ['uses' => 'TcUserController@updateSingleDcocumentStatus'])->name('tcuser.tcuser-update-document-status');
    Route::post('tcuser-update-document', ['uses' => 'TcUserController@updateDcocument'])->name('tcuser.tcuser-update-document');
    Route::get('tcuser-view-document', ['uses' => 'TcUserController@viewDocument'])->name('tcuser.view-document');
    Route::post('tcuser-mudra-posting-status', ['uses' => 'TcUserController@updateMudraPostingStatus'])->name('tcuser.mudra-posting-status');
    Route::post('tcuser-online-status', ['uses' => 'TcUserController@updateOnlineStatus'])->name('tcuser.online-status');
});

//incident Buy And Sell Margin get// using Ajax
Route::post('getBuyAndSellMargin', 'FrontController@getBuyAndSellMargin');
//Route::post('incidentInsert', 'FrontController@incidentInsert');
//Route::post('incidentInsert', ['uses' => 'FrontController@incidentInsert'])->name('incidentInsert');
Route::get('get-rate-plan', 'FrontController@getRatePlan');
Route::get('sendMail', 'FrontController@sendMail');


//forget password agent
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//forgot password tcuser
Route::get('forget-password-tc', [ForgotPasswordTCuserController::class, 'showForgetPasswordtcForm'])->name('forget.password.tc.get');
Route::post('forget-password-tc', [ForgotPasswordTCuserController::class, 'submitForgetPasswordtcForm'])->name('forget.password.tc.post'); 
Route::get('reset-password-tc/{token}', [ForgotPasswordTCuserController::class, 'showResetPasswordtcForm'])->name('reset.password.tc.get');
Route::post('reset-password-tc', [ForgotPasswordTCuserController::class, 'submitResetPasswordtcForm'])->name('reset.password.tc.post');
