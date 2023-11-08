<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssistController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PriceCalculationController;

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


Route::group(['middleware' => 'auth:sanctum'], function(){

        Route::get("logout",[AuthController::class,'logout']);
        Route::post("change-password",[AuthController::class,'ChangePassword']);
        Route::post("update-profile",[AuthController::class,'UpdateProfile']);
        Route::post("update-vehicle",[UserController::class,'UpdateVehicle']);
        Route::post("help",[AssistController::class,'Help']);
        Route::get("parents",[SchoolController::class,'GetParents']);

        Route::get("students",[SchoolController::class,'GetStudents']);
        Route::get("parent-profile",[UserController::class,'ParentProfile']);
        Route::get("children-parent-location",[UserController::class,'Childrenparents']);
        Route::get("user-profile",[UserController::class,'UserProfile']);
        Route::get("driver-profile",[UserController::class,'DriverProfile']);
        Route::get("student-driver-detail",[UserController::class,'studentDriverDetail']);
        Route::post("driver-status",[UserController::class,'DriverStatus']);
        
        //
        Route::get("schools",[SchoolController::class,'AllSchools']);
        
        Route::post("update-school-status",[SchoolController::class,'updateSchoolStatus']);
        Route::get("childrens-school",[SchoolController::class,'ParentSchools']);
        Route::post("student-not-going",[SchoolController::class,'StudentNotGoing']);
        Route::post("student-attendance",[SchoolController::class,'StudentGoing']);
        Route::get("start-time",[SchoolController::class,'StartTime']);
        Route::get("parent-school-data",[SchoolController::class,'ParentSchoolData']);
        Route::get("chat",[ChatController::class,'Chat']);
        Route::get("calender",[SchoolController::class,'Calender']);
        Route::get("childrens-list",[SchoolController::class,'ChildrenList']);
        Route::get("school-profile",[SchoolController::class,'SchoolProfile']);
        Route::post("school-pick-and-drop",[UserController::class,'ChildUpdatePD']);
        Route::get("school-requests",[UserController::class,'SchoolRequest']);
        Route::post("accept-invitation",[UserController::class,'SchoolInvitation']);
        Route::post("delay-notification",[UserController::class,'Delay']);
        Route::get("daily-alerts",[UserController::class,'DailyAlerts']);
        Route::get("notifications",[UserController::class,'notifications']);
        Route::post("children-address-update",[UserController::class,'CAU']);
    
 

});
 


        /* Authontication Module */
        Route::post("social-login",[UserController::class,'socialAuth']);
        Route::post("signup",[AuthController::class,'SignUp']);
        Route::post("resendotp",[AuthController::class,'ResendOtp']);
        Route::post("verification",[AuthController::class,'Verification']);
        Route::post("login",[AuthController::class,'Login']);
        Route::post("forgot-password",[AuthController::class,'forgotPassword']);
        Route::post("forgetpasswordverify",[AuthController::class,'forgotPasswordOtpVerify']);
        Route::post("resetforgetpassword",[AuthController::class,'resetForgotPassword']);
        Route::get("content",[ContentController::class,'content']);

        Route::get("calculate-price",[PriceCalculationController::class,'calculatePrice']);
 
  

        
