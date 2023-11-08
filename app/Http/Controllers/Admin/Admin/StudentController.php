<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function students()
    {

        $students = User::
            join('schools', 'schools.id', 'users.school_id')
            ->join('counties', 'counties.id', 'schools.county_id')
            ->join('parents as user_parent', 'user_parent.id', 'users.parent_id')
            ->join('teachers', 'teachers.id', 'users.created_by')
            ->join('drivers', 'drivers.id', 'users.driver_id')
            ->select(
                'users.id',
                'users.school_id',
                'users.name as student_name',
                'users.email',
                'user_parent.name as parent_name',
                'schools.school_name',
                'counties.county_name',
                'teachers.name as teacher_name',
                'drivers.name as driver_name',
            )
            ->where('users.role', 'student')->get();
        // return $students;
        return view('Admin.students.index', compact('students'));
    }

    public function studentDetail($student_id)
    {
        $student_attendance = User::with('attendance','driver.vehicle')->whereId($student_id)->firstOrFail();
        return view('Admin.students.student-detail' , compact('student_attendance'));
    }
}
