<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getStudents()
    {
        $school_ids = School::where('invited_by', auth('admin')->id())->pluck('id');

        $students = User::
                        join('teachers', 'teachers.id', 'users.created_by')
                        ->join('schools', 'schools.id', 'users.school_id')
                        ->join('counties', 'counties.id', 'schools.county_id')
                        ->join('users as parents', 'parents.id', 'users.parent_id')
                        ->select(
                            'users.id',
                            'users.name as student_name',
                            'users.email',
                            'parents.name as parent_name',
                            'teachers.name as teacher_name',
                            'schools.school_name',
                            'counties.county_name',
                            // 'schools.id as school_id',
                            DB::raw('(select group_concat(driver_id) from school_drivers where school_drivers.school_id = schools.id) as driverIds'),
                            DB::raw('(select count(id) from drivers  where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                        )
                        ->whereIn('users.school_id',$school_ids)->get();
        // return $students;
        return view('County.students.index', compact('students'));
    }

    public function studentDetail($student_id)
    {
        $student_attendance = User::with('attendance','driver.vehicle')->whereId($student_id)->firstOrFail();
        return view('County.students.student-detail' , compact('student_attendance'));

    }
}
