<?php

namespace App\Http\Controllers\Admin\Teacher;

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
            ->join('drivers', 'drivers.id', 'users.driver_id')
            ->select(
                'users.id',
                'users.name as student_name',
                'users.email',
                'parents.name as parent_name',
                'drivers.name as driver_name'
                
            )
            ->where(['users.created_by' => auth('teacher')->id(), 'users.role' => 'student'])
            ->get();
        // return $students;
        return view('Teacher.students.index', compact('students'));
    }

    public function studentDetail($student_id)
    {
        $student_attendance = User::with('attendance','driver.vehicle')->whereId($student_id)->firstOrFail();
        
        return view('Teacher.students.student-detail', compact('student_id','student_attendance'));

    }

    public function deleteStudent($student_id)
    {
        DB::table('users')->where('id', $student_id)->delete();
        return redirect()->route('teacher-admin-students')->with('success', 'Student Deleted Successfully');
    }
}
