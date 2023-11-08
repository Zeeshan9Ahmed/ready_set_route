<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverDailyDistance;
use App\Models\School;
use App\Models\SchoolDriver;
use App\Models\SchoolUser;
use App\Services\Notification\PushNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function getDrivers()
    {
        $drivers = DB::table('drivers')
                    ->join('school_drivers','school_drivers.driver_id', 'drivers.id')
                    ->select(
                        'drivers.id',
                        'drivers.name',
                        'drivers.email',
                        'school_drivers.driver_id',
                        'school_drivers.school_id',
                        'school_drivers.status',
                        'school_drivers.is_accepted',
                        DB::raw('( select group_concat(id) from users where users.driver_id = drivers.id AND users.role = "student" ) as childrenIds '),
                        DB::raw(' (select count(id) from users where FIND_IN_SET(users.id, childrenIds ) ) as assinged_student_count '),
                        DB::raw('( select group_concat(parent_id) from users where users.driver_id = drivers.id AND users.role = "student" ) as parentIds '),
                        DB::raw(' (select count(id) from users where FIND_IN_SET(users.id, parentIds )  AND users.role = "parent") as parent_count_of_students '),
                    )
                    
                    ->where('school_drivers.school_id', auth('school')->id() )
                    ->groupBy([
                        'school_drivers.school_id', 'school_drivers.driver_id'
                    ])
                    ->get();
        // return $drivers;
        return view('School.drivers.index' , compact('drivers'));
    }

    public function driverDetail($driver_id)
    {
        // dd($driver_id);
        
        $students = DB::table('users')
                        ->join('users as parents', 'parents.id', 'users.parent_id')
                        ->join('teachers', 'teachers.id', 'users.created_by')
                        ->join('schools', 'schools.id', 'users.school_id')
                        ->select(
                            'users.id',
                            'users.name as student_name',
                            'users.email',
                            'parents.name as parent_name',
                            'teachers.name as teacher_name',
                            'schools.school_name'
                        )
                        ->where('users.driver_id', $driver_id)
                        ->get();
        // return $students;    
        return view('School.drivers.driver-detail', compact('students'));

    }
    
    public function inviteDrivers()
    {
        $drivers = DB::table('drivers')
                    ->select('id','name as driver_name', 'email')
                    ->whereRaw(DB::raw('( id not in (select driver_id from school_drivers where school_drivers.school_id = "'.auth('school')->id().'" ) )'))
                    ->get();
        return view('School.drivers.invite-drivers', compact('drivers'));
    }

    public function sendInvite(Request $request)
    {
        $data = [
            'driver_id' => $request->driver_id,
            'school_id' => auth('school')->id(),
            'status' => 'invited',
        ];
        $token = Driver::find($request->driver_id)?->device_token;
        $school_name = auth('school')->user()->school_name;
        $send_push = app(PushNotificationService::class)->execute(['title' => "You have got new request from  $school_name"],$token);
        
        SchoolDriver::create($data);
        
        return response()->json([
            'status' => 1,
            'message' => "Invitation Send Successfully"
        ]);
    }

    public function delaysReport($is_unread_notification = 0)
    {

        if($is_unread_notification) {
            auth('school')->user()->show_notification_red_dot = 0;
            auth('school')->user()->save();
        }
        $school_id = auth('school')->id();
        $delays = collect(DB::select('select  
                                notifications.id as notification_id,
                                vehicles.id as v_id,
                                drivers.name as driver_name,
                                schools.school_name as school_name,
                                counties.county_name as county_name,
                                vehicles.vehicle_number as vehicle_number,
                                DATE_FORMAT(notifications.created_at,"%D %M, %Y") as date,
                                TIME_FORMAT(notifications.created_at, "%h:%i %p") as time,
                                SUBSTRING_INDEX(notifications.description," said ", -1) as reason 
                                    from 
                                notifications 
                                join drivers ON drivers.id = user_id
                                left join vehicles ON vehicles.user_id = notifications.user_id
                                join schools ON schools.id = school_id
                                join counties ON counties.id = schools.county_id
                                where notification_type ="Bus Delay" AND notifications.school_id = "'.$school_id.'" GROUP BY notifications.id ORDER BY notifications.id DESC'));
        // return $delays;
        return view('School.delays.index', compact('delays'));
    }
}
