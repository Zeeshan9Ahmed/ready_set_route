<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function getSchools()
    {
        $schools = School::
                    select(
                        'schools.id',
                        'schools.school_name',
                        'schools.email',
                        DB::raw('(select count(id) from teachers where teachers.school_id = schools.id) as teacher_count'),
                        DB::raw('(select group_concat(parent_id) from users as parent_ids where FIND_IN_SET(parent_ids.school_id,schools.id)) as parentIds'), 
                        DB::raw('(select count(id) from users parents where FIND_IN_SET(parents.id,parentIds)) as parent_count'), 
                        DB::raw('(select count(id) from users where users.school_id = schools.id) as student_count'),
                        DB::raw('(select group_concat(driver_id) from school_drivers where school_drivers.school_id = schools.id) as driverIds'),
                        DB::raw('(select count(id) from drivers  where FIND_IN_SET(drivers.id,driverIds)) as driver_count'), 

                    )
                    ->where('invited_by', auth('admin')->id())
                    ->get();
        // return auth('admin')->id();
        // return $schools;
        // return 'hehehhe';
        return view('County.school.index', compact('schools'));
    }

    public function schoolDetail($school_id)
    {
        $teachers = DB::table('teachers')
                        ->select(
                            'teachers.id',
                            'teachers.name as teacher_name',
                            'teachers.email',
                            DB::raw('( select group_concat(parent_id) from users as students where students.school_id = teachers.school_id AND students.role = "student" ) as parentIds'),
                            DB::raw('( select group_concat(id) from users as students where students.school_id = teachers.school_id  AND students.role = "student" ) as studentIds'),
                            DB::raw('( select group_concat(driver_id) from school_drivers  where school_drivers.school_id = teachers.school_id ) as driverIds'),
                            DB::raw('(select count(id) from drivers  where FIND_IN_SET(drivers.id,driverIds)) as driver_count'), 
                            DB::raw('(select count(id) from users as students  where FIND_IN_SET(students.id,studentIds) AND students.role = "student") as student_count'), 
                            DB::raw('(select count(id) from users as parents  where FIND_IN_SET(parents.id,parentIds) AND parents.role = "parent") as parent_count'), 

                        ) 
                        ->where('teachers.school_id', $school_id)
                        ->get();
        // return $teachers;
        return view('County.school.school-detail', compact('teachers'));
    }
}
