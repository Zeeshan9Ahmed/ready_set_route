<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function schools()
    {
        $schools = School::join('counties', 'counties.id', 'schools.county_id')->
                        select(
                            'schools.id',
                            'schools.school_name',
                            'schools.email',
                            'counties.county_name',
                            DB::raw('(select count(id) from teachers where teachers.school_id = schools.id) as teacher_count'),
                            DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schools.id)) as driverIds'), 
                            DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                            DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student") as studentIds'), 
                            DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                            DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schools.id)) as parentIds'), 
                            DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'), 
                            )->get();


        
        // return $schools;
        
        return view('Admin.schools.index', compact('schools'));
    }

    public function schoolDetail($school_id)
    {

        $teachers = Teacher::
                    join('schools','schools.id','teachers.school_id')
                    ->join('counties', 'counties.id', 'schools.county_id')
                    ->select(
                        'teachers.id',
                        'teachers.name as teacher_name',
                        'teachers.email',
                        'schools.school_name',
                        'counties.county_name',
                            DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schools.id)) as driverIds'), 
                            DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                            DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student") as studentIds'), 
                            DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                            DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schools.id)) as parentIds'), 
                            DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),
                    )
                    ->where('school_id', $school_id)
                    ->get();
        // return $teachers;
        return view('Admin.schools.schools-detail', compact('teachers'));
        return $teachers;
        dd($school_id);

    }
}
