<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\CheckSubscriptionController;
use App\Http\Controllers\Controller;
use App\Models\PurchasePlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolDashboardController extends Controller
{
    public function schoolDashboard()
    {

        $dashboard_data = DB::table('schools')
            ->select(
                DB::raw('(select count(id) from teachers where teachers.school_id = schools.id ) as total_teachers'),
                DB::raw('(select group_concat(id) from users as students where FIND_IN_SET ( students.school_id, schools.id) AND students.role = "student" ) as studentIds  '),
                DB::raw('(select group_concat(parent_id) from users as students where FIND_IN_SET ( students.school_id, schools.id) AND students.role = "student" ) as parentIds '),
                DB::raw('(select group_concat(driver_id) from school_drivers as drivers where FIND_IN_SET ( drivers.school_id, schools.id ) ) as driverIds '),
                DB::raw('(select count(id) from users as students where FIND_IN_SET (students.id , studentIds) AND students.role = "student" ) as total_students'),
                DB::raw('(select count(id) from users as parents where FIND_IN_SET (parents.id , parentIds)  AND parents.role = "parent") as total_parents'),
                DB::raw('(select count(id) from drivers where FIND_IN_SET (drivers.id , driverIds)) as total_drivers'),
            )
            ->where('id', auth('school')->id())->first();
        // return $dashboard_data;

        $drivers = DB::select(
            'Select drivers.id,drivers.name  from drivers where id in ( select (driver_id) from school_drivers where school_drivers.school_id = ' . auth('school')->id() . '   )'
        );

        $teachers = DB::select(
            'Select teachers.id, teachers.name as teacher_name from teachers where teachers.school_id = '.auth('school')->id().''
        );
        // return $teachers;
        // return $drivers;
        return view('School.dashboard.index', compact('dashboard_data', 'drivers', 'teachers'));

    }

    

    public function SchoolTeacherDataCount(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $count = DB::table('users')
                    ->select(
                        DB::raw('(select count(id) from users where FIND_IN_SET (users.created_by, '.$teacher_id.') AND users.role = "student" ) as student_count'),
                        DB::raw('(select count(id) from users where FIND_IN_SET (users.created_by, '.$teacher_id.') AND users.role = "parent" ) as parent_count'),
                        DB::raw('(select group_concat(driver_id) from users as st where FIND_IN_SET(st.created_by,'.$teacher_id.') AND st.role = "student") as driverIds'), 
                        DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                    )
                    ->first();
        
        return $count;
    }

    public function schoolPage(CheckSubscriptionController $checkSubscriptionController)
    {

        if($checkSubscriptionController->checkSubscription($checkSubscriptionController->getCountyIdOfSchool(auth('school')->user()->county_id)) == false)
        {
            return view('School.page.index');
            // return redirect()->route('school-page');
        }else{

            return redirect()->route('schoolDashboard');
        };
    }
}
