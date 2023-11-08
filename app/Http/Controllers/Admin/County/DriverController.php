<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function getDrivers()
    {
        $school_ids =  School::where(['county_id' =>  auth('admin')->user()->county_id, 'invited_by' => auth('admin')->id()])->pluck('id');
        
        $drivers = DB::table('school_drivers')
                        ->join('drivers', 'drivers.id', 'school_drivers.driver_id')
                        ->join('schools', 'schools.id', 'school_drivers.school_id')
                        ->select(
                            'drivers.id',
                            'drivers.name as driver_name',
                            'drivers.email',
                            'schools.school_name',
                            'schools.id as school_id',
                            DB::raw('( select group_concat(id) from users as students where (students.driver_id = drivers.id AND students.school_id = schools.id) AND students.role = "student" ) as studentIds '),
                            DB::raw('( select group_concat(parent_id) from users where FIND_IN_SET (users.id , studentIds) AND users.role = "student" ) as parentIds '),
                            DB::raw('( select count(id) from users as st where FIND_IN_SET (st.id , studentIds) AND st.role = "student" ) as student_count '),
                            DB::raw('( select count(id) from users as pt where FIND_IN_SET (pt.id , parentIds) AND pt.role = "parent" ) as parent_count '),

                        )
                        ->whereIn('school_id', $school_ids)
                        ->groupBy([
                            'drivers.id','school_drivers.school_id','school_drivers.driver_id'
                        ])
                        ->get();
        // return $drivers;
        return view('County.drivers.index', compact('drivers'));
    }

    public function driverDetail($driver_id, $school_id)
    { 
        $delays = DB::table('notifications')->where(['user_id' => $driver_id , 'title' => 'Bus Delay'])->get();
        
        
        // return $delays;
        // $students = DB::table('users')
        //                 ->join('users as parents', 'users.parent_id', 'parents.id')
        //                 ->join('teachers', 'users.created_by', 'teachers.id')
        //                 ->join('schools', 'users.school_id', 'schools.id')
        //                 ->select(
        //                     'users.id',
        //                     'users.name as student_name',
        //                     'parents.name as parent_name',
        //                     'teachers.name as teacher_name',
        //                     'schools.school_name'
        //                 )
        //                 ->where(['users.driver_id' => $driver_id , 'users.school_id' => $school_id , 'users.role' => 'student'])
        //                 ->get();
        // return $students;
        return view('County.drivers.driver-detail', compact('delays'));

    }
}
