<?php

use App\Http\Controllers\Admin\Admin\AdminMessageController;
use App\Http\Controllers\Admin\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\Admin\AdminReportController;
use App\Http\Controllers\Admin\Admin\AdminRequestController;
use App\Http\Controllers\Admin\Admin\AdminSubscriptionController;
use App\Http\Controllers\Admin\Admin\CountyController;
use App\Http\Controllers\Admin\Admin\DashboardController;
use App\Http\Controllers\Admin\Admin\DriverController;
use App\Http\Controllers\Admin\Admin\InviteController;
use App\Http\Controllers\Admin\Admin\LocateController;
use App\Http\Controllers\Admin\Admin\ParentController;
use App\Http\Controllers\Admin\Admin\SchoolController;
use App\Http\Controllers\Admin\Admin\StateController;
use App\Http\Controllers\Admin\Admin\StudentController;
use App\Http\Controllers\Admin\Admin\TeacherController;
use App\Services\PushNotificationService;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Admin\Authcontroller as AuthController;
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
require base_path('routes/county.php');
require base_path('routes/school.php');
require base_path('routes/teacher.php');

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login-process',[AuthController::class,'login_process'])->name('login-process');
Route::get('/forgot-password',[AuthController::class,'forgot'])->name('forgot-password');
Route::post('/forgot-password-process',[AuthController::class,'forgotPassword'])->name('forgot-password-process');


Route::group(['prefix' => 'admin' , 'middleware' => 'is_admin'], function () {
    Route::get('admin/invite',[InviteController::class, 'inviteForm']);
    Route::post('admin/invite-county',[InviteController::class, 'inviteCounty'])->name('inviteCounty');
    Route::get('/logout',[AuthController::class,'logout'])->name('admin_logout');

    Route::get("profile",[AdminController::class,"DashboardProfile"])->name("profile");
    Route::post("update-profile",[AdminController::class,"DashboardUpdateProfile"])->name("updateprofile");
    Route::post("change-password",[AdminController::class,"changePassword"])->name("admin_change_password");
    Route::post("change-image",[AdminController::class,"ChangeProfile"])->name("admin_change_image");



    Route::get('dashboard', [DashboardController::class , 'dashboard'])->name('admin-dashboard');
    
    Route::get('county-data-count', [DashboardController::class , 'countyDataCount'])->name('admin-county-data-count');

    Route::get('state-counties', [LocateController::class, 'getStateWiseCounty'])->name('admin-state-counties');
    Route::get('counties-school', [LocateController::class, 'countiesSchool'])->name('admin-counties-school');
    Route::get('school-drivers', [LocateController::class , 'schoolDrivers'])->name('admin-school-drivers');
    Route::get('drivers-students', [LocateController::class, 'getDriversStudents'])->name('admin-drivers-students');

    // Route::get('counties-school', [DashboardController::class , 'countiesSchool'])->name('admin-counties-school');
    
    Route::get('states', [DashboardController::class , 'states'])->name('admin-states');
    Route::get('state-detail/{state_id}', [StateController::class , 'stateDetail'])->name('admin-state-detail');


    Route::get('state-management', [StateController::class , 'addState'])->name('admin-state-management');
    Route::post('save-state', [StateController::class , 'saveState'])->name('admin-save-state');
    Route::post('save-county', [StateController::class , 'saveCounty'])->name('admin-save-county');


    Route::get('edit-state/{state_id}', [StateController::class , 'getState'])->name('admin-get-state');
    Route::post('edit-state', [StateController::class , 'editState'])->name('edit-state');
    Route::get('edit-county/{county_id}', [StateController::class , 'getCounty'])->name('admin-get-county');
    Route::post('edit-county', [StateController::class , 'editCounty'])->name('edit-county');


    Route::get('counties', [DashboardController::class , 'counties'])->name('admin-counties');
    Route::get('county-detail/{county_id}', [CountyController::class , 'countyDetail'])->name('admin-county-detail');
    
    Route::get('schools', [SchoolController::class , 'schools'])->name('admin-schools');
    Route::get('school-detail/{school_id}', [SchoolController::class , 'schoolDetail'])->name('admin-school-detail');


    Route::get('teachers', [TeacherController::class , 'teachers'])->name('admin-teachers');
    Route::get('teacher-detail/{teacher_id}', [TeacherController::class , 'teacherDetail'])->name('admin-teacher-detail');


    Route::get('parents', [ParentController::class , 'parents'])->name('admin-parents');
    Route::get('parent-detail/{parent_id}', [ParentController::class , 'parentDetail'])->name('admin-parent-detail');

    Route::get('students', [StudentController::class , 'students'])->name('admin-students');
    Route::get('student-detail/{student_id}', [StudentController::class , 'studentDetail'])->name('admin-student-detail');

    Route::get('drivers', [DriverController::class , 'drivers'])->name('admin-drivers');
    Route::get('driver-detail/{driver_id}/{school_id}', [DriverController::class , 'driverDetail'])->name('admin-driver-detail');

    
    Route::get('notifications', [AdminNotificationController::class , 'notifications']);
    Route::post('notification', [AdminNotificationController::class , 'send'])->name('admin_send_notification');
    
    
    Route::get('requests', [AdminRequestController::class , 'requests']);
    
    Route::get('subscription', [AdminSubscriptionController::class , 'subscription']);
    
    Route::get('subscription-history', [AdminSubscriptionController::class , 'subscriptionHistory']);

    Route::get('package', [AdminSubscriptionController::class , 'package']);
    Route::get('edit-package/{id}', [AdminSubscriptionController::class , 'editPackage']);
    Route::get('delete-package/{id}', [AdminSubscriptionController::class , 'deletePackage']);
    
    Route::post('edit-package', [AdminSubscriptionController::class , 'editPackageDetail']);
    Route::get('delete-package', [AdminSubscriptionController::class , 'deletePackageFeature'])->name('delete-package-feature');
    
    Route::post('save-package', [AdminSubscriptionController::class , 'savePackage']);

    Route::get('driver-vehicle/{driver_id}', [DriverController::class , 'driverVehicleDetail'])->name('school-admin-driver-vehicle');
    

    
    Route::get('messages', [AdminMessageController::class , 'messages']);
    Route::get('chat/{reciever_id}/{role}', [AdminMessageController::class , 'chat'])->name('admin_county_chat');
    
    
        Route::group(['prefix' => 'reports'], function () {
            Route::get('schools', [AdminReportController::class , 'schoolsReport']);
            Route::get('buses', [AdminReportController::class , 'busesReport']);
            Route::get('attendance', [AdminReportController::class , 'attendanceReport']);
            Route::get('delays/{is_unread_notification?}', [AdminReportController::class , 'delaysReport']);
            Route::get('financial', [AdminReportController::class , 'financialReport']);
            Route::get('travel', [AdminReportController::class , 'travelReport']);
            Route::get('get-filter-type', [AdminReportController::class , 'getFilterType'])->name('get_filter_type');
            Route::get('get-filtered-drivers', [AdminReportController::class , 'getFilteredDrivers'])->name('get_filtered_drivers');
            Route::get('filter-drivers-state-county-school-wise', [AdminReportController::class , 'filterDriversStateCountySchoolWise'])->name('filter_drivers_state_county_school_wise');
        });
        
        
        Route::get('test', [AuthController::class, 'test']);
    });
    
    Route::get('search', [AdminMessageController::class , 'search'])->name('admin_search_users');

   