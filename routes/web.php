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

// front page route 

Route::get('/', 'Front\WebController@index');
Route::get('job/{id}/{slug?}','Front\WebController@jobDetails')->name('job.details');
Route::post('job-application','Front\WebController@jobApply')->name('job.application');


// event meeting page route 
Route::get('meeting-page','Test\TestController@meeting')->name('meeting.page');
// front page route 


Route::get('login', 'User\LoginController@index');
Route::post('login', 'User\LoginController@Auth');

// Forget password and Reset Password
Route::post('submitForgetPasswordForm', 'User\LoginController@submitForgetPasswordForm');
Route::get('reset-password/{token}', 'User\LoginController@showResetPasswordForm')->name('show.reset.passwordForm.get');
Route::post('reset-password', 'User\LoginController@submitResetPasswordForm')->name('submit.reset.passwordForm.post');



Route::get('mail', 'User\HomeController@mail');

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::get('dashboard', 'User\HomeController@index');
    Route::get('profile', 'User\HomeController@profile');
    Route::get('logout', 'User\LoginController@logout');
    Route::get('downloadEmployeeProfilePdf','User\HomeController@employeeProfilePdfDownload');
    Route::resource('user','User\UserController',['parameters'=> ['user'=>'user_id']]);
    Route::resource('userRole','User\RoleController',['parameters'=> ['userRole'=>'role_id']]);
    Route::resource('rolePermission','User\RolePermissionController',['parameters'=> ['rolePermission'=>'id']]);
    Route::post('rolePermission/get_all_menu', 'User\RolePermissionController@getAllMenu');
    Route::resource('changePassword','User\ChangePasswordController',['parameters'=> ['changePassword'=>'id']]);

   

});


Route::get('local/{language}',function($language){

     session(['my_locale' => $language]);

     return redirect()->back();
});

// visitor request routes
Route::get('visitor-request','Visitor\VisitorRequestController@index')->name('visitor.request');
Route::get('visitor-request-approval/{appoinment_id}','Visitor\VisitorRequestController@visitorRequestApproval')->name('visitor.request.approval');
Route::get('visitor-request-rejected/{appoinment_id}','Visitor\VisitorRequestController@visitorRequestRejected')->name('visitor.request.rejected');