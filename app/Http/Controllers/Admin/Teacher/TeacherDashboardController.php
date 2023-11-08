<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\CheckSubscriptionController;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherDashboardController extends Controller
{
    public function teacherDashboard()
    {
        $school_id = auth('teacher')->user()->school_id;
        
        $dashboard_data = Teacher::select(
            DB::raw('( select count(id) from teachers where teachers.school_id = ' . $school_id . ' ) as total_teachers'),
            DB::raw('( select group_concat(id) from users where users.school_id = ' . $school_id . ' AND users.role = "student") as studentIds'),
            DB::raw('( select group_concat(id) from users where users.created_by = ' . auth('teacher')->id() . ' AND users.role = "parent") as parentIds'),
            DB::raw('( select group_concat(driver_id) from school_drivers where school_drivers.school_id = ' . $school_id . ' ) as driverIds'),
            DB::raw('( select count(id) from users as st where FIND_IN_SET(st.id, studentIds) AND st.role = "student" ) as total_students'),
            DB::raw('( select count(id) from users as pt where FIND_IN_SET(pt.id, parentIds) AND pt.role = "parent" ) as total_parents'),
            DB::raw('( select count(id) from drivers  where FIND_IN_SET(drivers.id, driverIds) ) as total_drivers'),
        )->first();
        // return $dashboard_data;
        $drivers = DB::select(
            'Select drivers.id,drivers.name  from drivers where id in ( select (driver_id) from school_drivers where school_drivers.school_id = '.$school_id.'   )'
        );

        // return $drivers;
        return view('Teacher.dashboard.index', compact('dashboard_data','drivers'));
    }

    

    public function DriverDataCount(Request $request)
    {
        $driver_id = $request->driver_id;

        $count = DB::table('users')
                    ->select(
                        DB::raw('(select count(id) from users where FIND_IN_SET (users.driver_id, '.$driver_id.') AND users.role = "student" ) as student_count'),
                        DB::raw('(select group_concat(parent_id) from users as st where FIND_IN_SET(st.driver_id,'.$driver_id.') AND st.role = "student") as parentIds'), 
                        DB::raw('(select count(id) from users pt where FIND_IN_SET(pt.id,parentIds) AND pt.role = "parent") as parent_count'),
                    )
                    ->first();
        
        return $count;
    }

    public function teacherPage(CheckSubscriptionController $subscription)
    {
        
        
        if($subscription->checkSubscription($subscription->getCountyIdOfSchool($subscription->getCountyIdOfTeacher(auth('teacher')->user()->school_id))) == false)
        {
            return view('Teacher.page.index');
        }else{

            return redirect()->route('teacherDashboard');
        };;

    }
}
