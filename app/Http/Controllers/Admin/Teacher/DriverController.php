<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function getDrivers()
    {
        $school_id = auth('teacher')->user()->school_id;
        
        $drivers = DB::table('school_drivers')
                        ->join('drivers','drivers.id','school_drivers.driver_id')
                        ->select(
                            'drivers.id',
                            'drivers.name as driver_name',
                            'drivers.email',
                            DB::raw('( select group_concat(id) from users as st where st.driver_id = drivers.id  AND st.role = "student") as studentIds'),
                            DB::raw('( select group_concat(parent_id) from users as st where st.driver_id = drivers.id  AND st.role = "student") as parentIds'),
                            DB::raw('( select count(id) from users as st where FIND_IN_SET(st.id, studentIds) AND st.role = "student" ) as total_students'),
                            DB::raw('( select count(id) from users as pt where FIND_IN_SET(pt.id, parentIds) AND pt.role = "parent" ) as total_parents'),
                        )
                        ->where('school_drivers.school_id', $school_id)
                        ->groupBy('school_drivers.driver_id')
                        ->get();
        // return $drivers;
        return view('Teacher.drivers.index', compact('drivers'));

    }

    public function driverDetail($driver_id)
    {
        $students = DB::table('users')
                        ->join('teachers', 'teachers.id', 'users.created_by')
                        ->join('users as parents', 'parents.id', 'users.parent_id')
                        ->join('schools', 'schools.id', 'users.school_id')
                        ->select(
                            'users.id',
                            'users.name as child_name',
                            'users.email',
                            'teachers.name as teacher_name',
                            'parents.name as parent_name',
                            'schools.school_name'
                        )
                        ->where('users.driver_id', $driver_id)
                        ->get();
        $driver = DB::table('drivers')
                        ->select(
                            'drivers.*',
                            )
                            ->selectRaw(' DATE_FORMAT((select created_at from school_drivers where school_id = "'.auth('teacher')->user()->school_id.'" AND driver_id = drivers.id order by created_at desc limit 1),"%d-%b-%Y") AS joining_date  ')
                            ->selectRaw('(select COUNT(id) from users where users.driver_id = drivers.id AND users.role = "student") as assigned_student_count')
                        ->whereId($driver_id)->first();
                        // return $driver;
        return view('Teacher.drivers.driver-detail', compact('students', 'driver'));

    }
    
    public function delaysReport($is_unread_notification = 0)
    {
        
        if($is_unread_notification) {
            auth('teacher')->user()->show_notification_red_dot = 0;
            auth('teacher')->user()->save();
        }
        $school_id = auth('teacher')->user()->school_id;

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
        return view('Teacher.delays.index', compact('delays'));
    }
}
