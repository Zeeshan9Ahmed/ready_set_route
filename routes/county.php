<?php

use App\Http\Controllers\Admin\County\AuthController as CountyAuthController;
use App\Http\Controllers\Admin\County\CountyAdminMessageController;
use App\Http\Controllers\Admin\County\CountyAdminNotificationController;
use App\Http\Controllers\Admin\County\CountyAdminSubscriptionController;
use App\Http\Controllers\Admin\County\CountyController;
use App\Http\Controllers\Admin\County\CountyDashboardController;
use App\Http\Controllers\Admin\County\CountyLocateController;
use App\Http\Controllers\Admin\County\DriverController;
use App\Http\Controllers\Admin\County\InviteController;
use App\Http\Controllers\Admin\County\ParentController;
use App\Http\Controllers\Admin\County\ProfileController;
use App\Http\Controllers\Admin\County\SchoolController;
use App\Http\Controllers\Admin\County\StudentController;
use App\Http\Controllers\Admin\County\TeacherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'sub-admin-county'], function () {
    Route::get('/login',[CountyAuthController::class ,'loginForm'])->name('countyLoginForm');
    Route::post('/county-login',[CountyAuthController::class ,'countyLogin'])->name('countyLogin');
    

    
    Route::post('register-county', [CountyController::class, 'registerCounty'])->name('register-county');
    Route::get('/registration/{mail}/{code}',[CountyAuthController::class,'registration'])->name('countyregistration');




    Route::group(['middleware' => 'is_county_admin'], function () {

        Route::get('subscription', [CountyAdminSubscriptionController::class , 'subscription']);
        Route::post('plan-post', [CountyAdminSubscriptionController::class , 'plan_post'])->name('plan.post');
        Route::get('/logout',[CountyAuthController::class,'logout'])->name('county_admin_logout');

        Route::group(['middleware' => 'is_plan_purchase'], function () {


            Route::get('/profile',[CountyAuthController::class,'getProfile'])->name('get-county-profile');
            

            Route::post("update-profile",[ProfileController::class,"DashboardUpdateProfile"])->name("county_updateprofile");
            Route::post("change-password",[ProfileController::class,"changePassword"])->name("county_change_password");
            Route::post("change-image",[ProfileController::class,"ChangeImage"])->name("county_change_image");
        

            Route::get('dashboard',[CountyDashboardController::class, 'countyDashboard'])->name('countyDashboard');
            Route::get('county-school-data-count', [CountyDashboardController::class , 'countySchoolDataCount'])->name('county-school-data-count');

        
            Route::get('school-drivers', [CountyLocateController::class , 'schoolDrivers'])->name('county-school-drivers');
            Route::get('drivers-students', [CountyLocateController::class, 'getDriversStudents'])->name('county-drivers-students');
            

            //
            Route::get('/invite',[InviteController::class, 'inviteForm']);


            Route::post('/invite-school',[InviteController::class, 'inviteSchool'])->name('inviteSchool');

            //school
            Route::get('schools', [SchoolController::class, 'getSchools'])->name('county-admin-schools');
            Route::get('school-detail/{school_id}', [SchoolController::class , 'schoolDetail'])->name('county-admin-school-detail');

            //teacher
            Route::get('teachers', [TeacherController::class, 'getTeachers'])->name('county-admin-teachers');
            Route::get('teacher-detail/{teacher_id}', [TeacherController::class , 'teacherDetail'])->name('county-admin-teacher-detail');



            //parent
            Route::get('parents', [ParentController::class, 'getParents'])->name('county-admin-parents');
            Route::get('parent-detail/{parent_id}', [ParentController::class , 'parentDetail'])->name('county-admin-parent-detail');

            //students
            Route::get('students', [StudentController::class, 'getStudents'])->name('county-admin-students');
            Route::get('student-detail/{student_id}', [StudentController::class , 'studentDetail'])->name('county-admin-student-detail');

            //driver
            Route::get('drivers', [DriverController::class, 'getDrivers'])->name('county-admin-drivers');
            Route::get('driver-detail/{driver_id}/{school_id}', [DriverController::class , 'driverDetail'])->name('county-admin-driver-detail');



            Route::get('notifications', [CountyAdminNotificationController::class , 'notifications']);
            Route::post('notifications', [CountyAdminNotificationController::class , 'send'])->name('county_send_notification');
            
        
            
            
            Route::get('messages', [CountyAdminMessageController::class , 'messages']);
            Route::get('chat/{reciever_id}/{role}', [CountyAdminMessageController::class , 'chat'])->name('county_chat');


        });
    });
    



    
});
