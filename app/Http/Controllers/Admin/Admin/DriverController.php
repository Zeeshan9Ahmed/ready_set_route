<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverDailyDistance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function drivers()
    {
        $drivers = Driver::
                    join('school_drivers', 'drivers.id','school_drivers.driver_id')
                    ->join('schools','schools.id', 'school_drivers.school_id')
                    ->select(
                        'drivers.id',
                        'drivers.name as driver_name',
                        'drivers.email',
                        'school_drivers.school_id',
                        'schools.school_name',
                        
                            DB::raw('( select group_concat(id) from users as students where (students.driver_id = drivers.id AND students.school_id = schools.id) AND students.role = "student" ) as studentIds '),
                            DB::raw('( select group_concat(parent_id) from users where FIND_IN_SET (users.id , studentIds) AND users.role = "student" ) as parentIds '),
                            DB::raw('( select count(id) from users as st where FIND_IN_SET (st.id , studentIds) AND st.role = "student" ) as student_count '),
                            DB::raw('( select count(id) from users as pt where FIND_IN_SET (pt.id , parentIds) AND pt.role = "parent" ) as parent_count '),

                    )
                    
                    ->where('school_drivers.status','created')
                    ->get();
        // return $drivers;
        return view('Admin.drivers.index', compact('drivers'));
    }

    public function driverDetail($driver_id, $school_id)
    {
        // dd($driver_id,$school_id);
        $students = User::
                    join('users as parents','parents.id', 'users.parent_id')
                    ->join('teachers', 'teachers.id', 'users.created_by')
                    ->join('schools', 'schools.id', 'users.school_id')
                    ->join('counties', 'counties.id', 'schools.county_id')
                    ->select(
                        'users.id',
                        'users.name as student_name',
                        'parents.name as parent_name',
                        'teachers.name as teacher_name',
                        'schools.school_name',
                        'counties.county_name'
                    )
                    ->where(['users.driver_id' => $driver_id, 'users.school_id' => $school_id])
                    ->get();
                    // return $students;
        return view('Admin.drivers.driver-detail', compact('students'));
        dd($driver_id);
    }

    public function driverVehicleDetail($driver_id) {
        $driver_distances = DriverDailyDistance::where('driver_id', $driver_id)
                                ->orderBy('id')
                                ->get();
        return view('Admin.reports.buses.vehicle-detail',compact('driver_distances') );

    }
}
