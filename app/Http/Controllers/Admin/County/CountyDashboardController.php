<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolTeacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountyDashboardController extends Controller
{
    public function countyDashboard()
    {
       

        $dashboard_data = School::select(
            DB::raw('(select group_concat(id) from schools where schools.county_id = ' . auth('admin')->user()->county_id . ' AND schools.invited_by = ' . auth('admin')->id() . ') as schoolIds  '),
            DB::raw('(select count(id) from schools where FIND_IN_SET (schools.id , schoolIds) ) as total_schools'),
            DB::raw('(select count(id) from teachers where FIND_IN_SET (teachers.school_id , schoolIds) ) as total_teachers'),
            DB::raw('(select group_concat(id) from users as students where FIND_IN_SET ( students.school_id, schoolIds) AND students.role = "student" ) as studentIds  '),
            DB::raw('(select group_concat(parent_id) from users as students where FIND_IN_SET ( students.school_id, schoolIds) AND students.role = "student" ) as parentIds '),
            DB::raw('(select group_concat(driver_id) from school_drivers as drivers where FIND_IN_SET ( drivers.school_id, schoolIds) ) as driverIds '),
            DB::raw('(select count(id) from users as students where FIND_IN_SET (students.id , studentIds) AND students.role = "student" ) as total_students'),
            DB::raw('(select count(id) from users as parents where FIND_IN_SET (parents.id , parentIds)  AND parents.role = "parent") as total_parents'),
            DB::raw('(select count(id) from drivers where FIND_IN_SET (drivers.id , driverIds)) as total_drivers'),

        )->first();
        $schools = [];
        
        if ( $dashboard_data )
        {
            if ( $dashboard_data->schoolIds != null ){
                $schools = DB::select(
                    'Select id,school_name from schools where id in ('.$dashboard_data->schoolIds.')'
                );
            }
        }
        

       
        return view('County.dashboard.index', compact('dashboard_data', 'schools'));
    }

    public function countySchoolDataCount(Request $request)
    {
        
        $count = DB::table('schools')
                    ->select(
                        DB::raw('(select count(id) from teachers where FIND_IN_SET (teachers.school_id, schools.id) ) as teacher_count'),
                        DB::raw('(select group_concat(distinct id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student") as studentIds'), 
                        DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                        DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schools.id)) as parentIds'), 
                        DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),
                        DB::raw('(select group_concat(distinct driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schools.id)) as driverIds'), 
                        DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                    )
                    ->where('schools.id', $request->school_id)
                    ->first();
        // return $count;
        return $count;
    }
}
