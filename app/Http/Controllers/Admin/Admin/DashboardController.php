<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\County;
use App\Models\School;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        
        
        $dashboard_data = State::select(
            DB::raw('(select count(id)  from states) as total_states'),
            DB::raw('(select count(id)  from counties) as total_counties'),
            DB::raw('(select count(id)  from schools) as total_schools'),
            DB::raw('(select count(id)  from drivers) as total_drivers'),
            DB::raw('(select count(id)  from teachers) as total_teachers'),
            DB::raw('(select count(id)  from users as students where students.role = "student") as total_students'),
            DB::raw('(select count(id)  from users as parents where parents.role = "parent") as total_parents'),

        )->first();


        $states = DB::table('states')->select('id', 'state_name')->get();

        $counties = DB::table('counties')->select('id', 'county_name')->get();
        // return $counties;
        return view('dashboard.dashboard', compact('dashboard_data', 'states', 'counties'));
    }

    public function countiesSchool(Request $request)
    {
        $schools = School::where('county_id', $request->county_id)->get();
        return json_encode($schools);
    }

    public function schoolDrivers(Request $request)
    {
        $drivers = User::where(['school_id' => $request->school_id, 'role' => 'driver'])->get();
        return json_encode($drivers);
    }

    public function states()
    {
        $states = State::select(
            'states.id',
            'states.state_name',
            DB::raw('(select group_concat(id) from counties as cou where (cou.state_id = states.id)) as countyIds'),
            DB::raw('(select count(id)  from counties where state_id = states.id ) as total_counties'),
            DB::raw('(select count(id) from schools as sc where FIND_IN_SET(sc.county_id,countyIds)) as school_count'),
            DB::raw('(select group_concat(id) from schools as sc where FIND_IN_SET(sc.county_id,countyIds)) as schoolIds'),
            DB::raw('(select count(id) from teachers as st where FIND_IN_SET(st.school_id,schoolIds)) as teacher_count'),
            DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schoolIds)) as driverIds'),
            DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schoolIds) AND upt.role = "student") as studentIds'),
            DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
            DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds) ) as driver_count'),
            DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schoolIds)) as parentIds'),
            DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),
        )
            ->groupBy('states.id')->get();


        // return $states;


        return view('Admin.states.index', compact('states'));
    }

    public function counties()
    {
        $counties = County::leftjoin('admins', 'admins.id', 'counties.admin_id')
            ->select(
                'counties.id',
                'counties.county_name',
                'admins.name',
                'admins.email',
                DB::raw('(select count(id)  from schools where county_id = counties.id ) as total_schools'),
                DB::raw('(select group_concat(id) from schools as sc where FIND_IN_SET(sc.county_id,counties.id)) as schoolIds'),
                DB::raw('(select count(id) from teachers as st where FIND_IN_SET(st.school_id,schoolIds)) as teacher_count'),
                DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schoolIds)) as driverIds'),
                DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schoolIds) AND upt.role = "student") as studentIds'),
                DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schoolIds)) as parentIds'),
                DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),


            )->get();
        // return $counties;
        return view('Admin.counties.index', compact('counties'));
    }

    public function countyDataCount(Request $request)
    {

        $count = DB::table('schools')
            ->select(
                DB::raw('(select group_concat(id) from schools where county_id = ' . $request->county_id . ' ) as schoolIds'),
                DB::raw('(select count(id) from schools where FIND_IN_SET (schools.id, schoolIds) ) as school_count'),
                DB::raw('(select count(id) from teachers where FIND_IN_SET (teachers.school_id, schoolIds) ) as teacher_count'),
                DB::raw('(select group_concat(distinct id) from users as upt where FIND_IN_SET(upt.school_id,schoolIds) AND upt.role = "student") as studentIds'),
                DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                DB::raw('(select group_concat(distinct parent_id) from users as upt where FIND_IN_SET(upt.school_id,schoolIds)) as parentIds'),
                DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),
                DB::raw('(select group_concat(distinct driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schoolIds)) as driverIds'),
                DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
            )
            ->first();
        // return $count;
        return $count;
    }
}
