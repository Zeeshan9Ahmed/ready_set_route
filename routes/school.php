<?php

use App\Http\Controllers\Admin\County\CountyController;
use App\Http\Controllers\Admin\School\SchoolAuthController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\School\TeacherController;
use App\Http\Controllers\Admin\School\ParentController;
use App\Http\Controllers\Admin\School\StudentController;
use App\Http\Controllers\Admin\School\DriverController;
use App\Http\Controllers\Admin\School\InviteController;
use App\Http\Controllers\Admin\School\SchoolAdminMessageController;
use App\Http\Controllers\Admin\School\SchoolAdminNotificationController;
use App\Http\Controllers\Admin\School\SchoolDashboardController;
use App\Http\Controllers\Admin\School\SchoolLocateController;
use App\Http\Controllers\Admin\School\SchoolProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'sub-admin-school'], function () {
    Route::get('/login',[SchoolAuthController::class ,'loginForm'])->name('schoolLoginForm');
    Route::post('/login',[SchoolAuthController::class ,'schoolLogin'])->name('schoolLogin');
    Route::post('register-school-admin', [SchoolController::class, 'registerSchoolAdmin'])->name('register-school-admin');
    Route::get('/registration/{mail}/{code}',[SchoolAuthcontroller::class,'registration'])->name('schoolregistration');
    Route::get('school/register/{school_id}', [SchoolController::class, 'schoolForm'])->name('school-form');
    Route::post('save-school', [SchoolController::class, 'saveSchool'])->name('save-school');
    
    //school_has_plan
    Route::group(['middleware' => 'is_school_admin' ], function () {


        Route::get('page', [SchoolDashboardController::class, 'schoolPage'])->name('school-page');

        Route::group(['middleware' => 'school_has_plan' ], function () {

            Route::get('/invite',[InviteController::class, 'inviteForm']);
            Route::post('/invite-teacher',[InviteController::class, 'inviteTeacher'])->name('inviteTeacher');
            Route::get('/profile',[SchoolAuthController::class,'getProfile'])->name('get-school-admin-profile');
    
            Route::post("update-profile",[SchoolProfileController::class,"DashboardUpdateProfile"])->name("school-admin-updateprofile");
            Route::post("change-password",[SchoolProfileController::class,"changePassword"])->name("school_admin_change_password");
            Route::post("change-image",[SchoolProfileController::class,"ChangeImage"])->name("school_change_image");
    
            
            
            Route::get('/logout',[SchoolAuthController::class ,'logout'])->name('school_admin_logout');
    
            Route::get('/dashboard',[SchoolDashboardController::class, 'schoolDashboard'])->name('schoolDashboard');
            Route::get('school-teacher-data-count', [SchoolDashboardController::class , 'SchoolTeacherDataCount'])->name('school-teacher-data-count');
    
            Route::get('drivers-students', [SchoolLocateController::class, 'getDriversStudents'])->name('school-drivers-students');
    
    
            Route::get('create-driver', [SchoolController::class, 'createDriver'])->name('createDriver');
            Route::post('save-driver', [SchoolController::class, 'saveDriver'])->name('save-driver');
    
            Route::get('teachers', [TeacherController::class, 'getTeachers'])->name('school-admin-teachers');
            Route::get('teacher-detail/{teacher_id}', [TeacherController::class , 'teacherDetail'])->name('school-admin-teacher-detail');
    
            //parent
            Route::get('parents', [ParentController::class, 'getParents'])->name('school-admin-parents');
            Route::get('parent-detail/{parent_id}', [ParentController::class , 'parentDetail'])->name('school-admin-parent-detail');
    
            //students
            Route::get('students', [StudentController::class, 'getStudents'])->name('school-admin-students');
            Route::get('student-detail/{student_id}', [StudentController::class , 'studentDetail'])->name('school-admin-student-detail');
    
            //driver
            Route::get('drivers', [DriverController::class, 'getDrivers'])->name('school-admin-drivers');
            Route::get('invite-drivers', [DriverController::class, 'inviteDrivers'])->name('school-admin-invite-drivers');
    
            Route::post('send-invite', [DriverController::class, 'sendInvite'])->name('school-admin-send-invite');
            
            Route::get('driver-detail/{driver_id}', [DriverController::class , 'driverDetail'])->name('school-admin-driver-detail');
            Route::get('delays/{is_unread_notification?}', [DriverController::class , 'delaysReport'])->name('school-admin-delays');
    
    
            Route::get('notifications', [SchoolAdminNotificationController::class , 'notifications']);
            Route::post('notifications', [SchoolAdminNotificationController::class , 'send'])->name('school_send_notification');
    
            Route::get('messages', [SchoolAdminMessageController::class , 'messages']);
            
            Route::get('chat/{reciever_id}/{role}', [SchoolAdminMessageController::class , 'chat'])->name('school_chat');
        });

        


        
    });


    Route::get('state-counties', [CountyController::class, 'getStateWiseCounty'])->name('state-counties');
    // Route::post('register-county', [CountyController::class, 'registerCounty'])->name('register-county');
});
