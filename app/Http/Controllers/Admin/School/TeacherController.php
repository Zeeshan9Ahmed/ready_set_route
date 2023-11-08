<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function getTeachers()
    {
        
        $teachers = Teacher::
                        select(
                            'teachers.id',
                            'teachers.name as teacher_name',
                            'teachers.email',
                            DB::raw('(select count(id) from users as students where students.created_by = teachers.id AND students.role = "student" )as total_students_created'),
                            DB::raw('(select count(id) from users as parents where parents.created_by = teachers.id AND parents.role = "parent" )as total_parents_created'),
                        )
                        ->where('school_id', auth('school')->id())
                        ->get();
        // return $teachers;
        // return 'teachers';

        return view('School.teachers.index' , compact('teachers'));
        
    }

    public function teacherDetail($teacher_id)
    {
        $parents = DB::table('users')
                    ->select(
                        'users.id',
                        'users.name as parent_name',
                        'users.email',
                        DB::raw('(select group_concat(id) from users as child where child.parent_id = users.id AND child.role = "student") as childIds'),
                        DB::raw('(select group_concat(driver_id) from users as child where child.parent_id = users.id AND child.role = "student") as driverIds'),
                        DB::raw('(select count(id) from users as child where FIND_IN_SET ( child.id ,childIds) ) as children_count'),
                        DB::raw('(select count(id) from drivers where FIND_IN_SET ( drivers.id ,driverIds) ) as children_driver_count'),
                    )
                    ->where(['users.created_by' => $teacher_id , 'users.role' => 'parent'])
                    ->get();
        // return 'teachers';
        // return $parents;
        return view('School.teachers.teacher-detail' , compact('parents'));

    }
}
