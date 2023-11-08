<?php

use App\Http\Controllers\Admin\County\CountyController;
use App\Http\Controllers\Admin\Teacher\TeacherAuthController;
use App\Http\Controllers\Admin\Teacher\TeacherDashboardController;
use App\Http\Controllers\Admin\Teacher\ParentController;
use App\Http\Controllers\Admin\Teacher\StudentController;
use App\Http\Controllers\Admin\Teacher\DriverController;
use App\Http\Controllers\Admin\Teacher\TeacherAdminMessageController;
use App\Http\Controllers\Admin\Teacher\TeacherAdminNotificationController;
use App\Http\Controllers\Admin\Teacher\TeacherLocateController;
use App\Http\Controllers\Admin\Teacher\TeacherProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'sub-admin-teacher'], function () {
    Route::get('/login',[TeacherAuthController::class ,'loginForm'])->name('teacherLoginForm');
    Route::post('/login',[TeacherAuthController::class ,'teacherLogin'])->name('teacherLogin');
    Route::get('/registration/{mail}/{code}',[TeacherAuthController::class,'registration'])->name('teacherregistration');
    Route::post('register-teacher', [TeacherAuthController::class, 'saveTeacher'])->name('register-teacher');

    Route::group(['middleware' => 'is_teacher_admin'] , function () {

        Route::get('page', [TeacherDashboardController::class, 'teacherPage'])->name('teacher-page');

        Route::group(['middleware' => 'teacher_has_plan'] , function () {

        Route::get('/profile',[TeacherProfileController::class,'getProfile'])->name('get-teacher-profile');

        Route::post("update-profile",[TeacherProfileController::class,"DashboardUpdateProfile"])->name("teacher-admin-updateprofile");
        Route::post("change-password",[TeacherProfileController::class,"changePassword"])->name("teacher_admin_change_password");
        Route::post("change-image",[TeacherProfileController::class,"ChangeImage"])->name("teacher_change_image");

        
        Route::get('/logout',[TeacherAuthController::class ,'logout'])->name('teacher_logout');

        Route::get('/dashboard',[TeacherDashboardController::class, 'teacherDashboard'])->name('teacherDashboard');
        Route::get('driver-data-count', [TeacherDashboardController::class , 'DriverDataCount'])->name('driver-data-count');



        Route::get('drivers-students', [TeacherLocateController::class, 'getDriversStudents'])->name('teacher-drivers-students');

        //parent
        Route::get('parents', [ParentController::class, 'getParents'])->name('teacher-admin-parents');
        Route::get('parent', [ParentController::class, 'parentForm'])->name('teacher-admin-parent-view');
        Route::post('save-parent', [ParentController::class, 'saveParent'])->name('teacher-admin-parent-save');
        
        Route::get('child/{parent_id}', [ParentController::class, 'childForm'])->name('teacher-admin-child-view');
        Route::get('delete/parent/{parent_id}', [ParentController::class, 'deleteParent'])->name('teacher-admin-delete-parent');
        Route::post('add-child', [ParentController::class, 'addChild'])->name('teacher-admin-add-child');
        Route::get('parent-detail/{parent_id}', [ParentController::class , 'parentDetail'])->name('teacher-admin-parent-detail');

        //students
        Route::get('students', [StudentController::class, 'getStudents'])->name('teacher-admin-students');
        Route::get('student-detail/{student_id}', [StudentController::class , 'studentDetail'])->name('teacher-admin-student-detail');
        Route::get('delete/student/{student_id}', [StudentController::class, 'deleteStudent'])->name('teacher-admin-delete-student');

        //driver
        Route::get('drivers', [DriverController::class, 'getDrivers'])->name('teacher-admin-drivers');
        Route::get('driver-detail/{driver_id}', [DriverController::class , 'driverDetail'])->name('teacher-admin-driver-detail');
        Route::get('delays/{is_unread_notification?}', [DriverController::class , 'delaysReport'])->name('teacher-admin-delays');
        
        Route::get('notifications', [TeacherAdminNotificationController::class , 'notifications']);
        Route::post('notifications', [TeacherAdminNotificationController::class , 'send'])->name('teacher_send_notification');

        Route::get('messages', [TeacherAdminMessageController::class , 'messages']);

        Route::get('chat/{reciever_id}/{role}', [TeacherAdminMessageController::class , 'chat'])->name('teacher_chat');

    });


    });


});

