<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function getTeachers()
    {
        $school_ids = School::where('invited_by', auth('admin')->id())->pluck('id');
        // return $school_ids;
        $teachers = Teacher::
                        join('schools', 'schools.id', 'teachers.school_id')
                        ->select(
                            'teachers.id',
                            'teachers.name as teacher_name',
                            'teachers.email',
                            'schools.school_name',
                            'schools.id as school_id',

                            DB::raw('(select group_concat(parent_id) from users as parent_ids where FIND_IN_SET(parent_ids.school_id,schools.id) AND parent_ids.role = "student") as parentIds'), 
                            DB::raw('(select count(id) from users as parents where FIND_IN_SET(parents.id,parentIds)) as parent_count'),
                            DB::raw('(select count(id) from users as us where FIND_IN_SET(us.school_id,schools.id) AND us.role = "student") as student_count'), 
                            DB::raw('(select group_concat(driver_id) from school_drivers where school_drivers.school_id = schools.id) as driverIds'),
                            DB::raw('(select count(id) from drivers  where FIND_IN_SET(drivers.id,driverIds)) as driver_count'), 
                        )
                        ->whereIn('school_id', $school_ids)
                        ->get();
        
        return view('County.teachers.index', compact('teachers'));
    }

    public function teacherDetail($teacher_id)
    {
        // dd($teacher_id);
        $parents = DB::table('users')
                    ->join('teachers', 'teachers.id', 'users.created_by')
                    ->join('schools', 'schools.id', 'teachers.school_id')
                    ->select(
                        'users.id',
                        'users.name as parent_name',
                        'teachers.name as teacher_name',
                        'teachers.email',
                        'schools.school_name',
                        DB::raw('(select group_concat(id) from users as child where FIND_IN_SET(child.parent_id,users.id) AND child.role = "student") as childIds'), 
                        DB::raw('(select group_concat(driver_id) from users as child where FIND_IN_SET(child.id,childIds) AND child.role = "student") as driverIds'), 
                        DB::raw('(select count(id) from drivers  where FIND_IN_SET(drivers.id,driverIds)) as driver_count'), 
                        DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,childIds) AND us.role = "student") as student_count'), 

                    )
                    ->where(['users.created_by' => $teacher_id, 'users.role' => 'parent'])
                    ->get();
        // return $parents;
        return view('County.teachers.teacher-details', compact('parents'));
    }
}
