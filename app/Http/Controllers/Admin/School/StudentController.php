<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getStudents()
    {
        $students = DB::table('users')
                        ->join('users as parents', 'parents.id', 'users.parent_id')
                        ->join('teachers', 'teachers.id', 'users.created_by')
                        ->leftjoin('drivers', 'drivers.id', 'users.driver_id')
                        ->select(
                            'users.id',
                            'users.name as student_name',
                            'users.email',
                            'parents.name as parent_name',
                            'teachers.name as teacher_name',
                            'drivers.name as driver_name'
                        )
                        ->where('users.school_id', auth('school')->id())
                        ->get();
        // return  '';
        // return $students;
        return view('School.students.index', compact('students'));
    }

    public function studentDetail($student_id)
    {
        $student_attendance = User::with('attendance','driver.vehicle')->whereId($student_id)->firstOrFail();
        // return $student_attendance;
        return view('School.students.student-detail', compact('student_attendance'));
    }
}
