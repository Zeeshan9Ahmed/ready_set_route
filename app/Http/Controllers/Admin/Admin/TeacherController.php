<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function teachers()
    {

        $teachers = Teacher::join('schools', 'schools.id', 'teachers.school_id')
            ->join('counties', 'counties.id', 'schools.county_id')
            ->select(
                'teachers.id as teacher_id',
                'teachers.name as teacher_name',
                'teachers.email',
                'schools.school_name',
                'counties.county_name',
                'teachers.school_id',
                DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,teachers.school_id)) as driverIds'), 
                DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'), 
                DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,teachers.school_id) AND upt.role = "student") as studentIds'),
                DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,teachers.school_id) AND upt.role = "student") as parentIds'),
                DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),
                
            )
            ->get();
        // return $teachers;
        return view('Admin.teachers.index', compact('teachers'));
    }

    public function teacherDetail($teacher_id)
    {

        $parents = DB::table('users')
            ->where(['users.role' => 'parent', 'users.created_by' => $teacher_id])
            ->join('users as uu', 'uu.parent_id', 'users.id')
            ->join('schools', 'schools.id', 'uu.school_id')
            ->join('counties', 'counties.id', 'schools.county_id')
            ->select(
                'users.id as parent_id',
                'users.role as parent_role',
                'users.name as parent_name',
                'users.email',
                'uu.id',
                'uu.role',
                'uu.name',
                'uu.school_id',
                'schools.id as school_id',
                'schools.school_name',
                'counties.id as county_id',
                'counties.county_name',
                DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student" AND FIND_IN_SET(upt.parent_id,users.id)) as studentIds'),
                DB::raw('(select group_concat(driver_id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student" AND FIND_IN_SET(upt.parent_id,users.id)) as driverIds'),
                DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
            )
            ->orderBy('parent_id')
            ->groupBy(['school_name', 'parent_name'])
            ->get();
        // return $parents;
        return view('Admin.teachers.teachers-detail', compact('parents'));
        
    }
}
