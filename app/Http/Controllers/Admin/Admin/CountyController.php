<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountyController extends Controller
{
    public function countyDetail($county_id)
    {
        $admin = DB::table('admins')->where('county_id', $county_id)->first();
        
        $schools = School::
                    select(
                        'schools.id',
                        'schools.school_name',
                        DB::raw('(select count(id) from teachers where teachers.school_id = schools.id) as teacher_count'),
                        DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schools.id)) as driverIds'), 
                        DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                        DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student") as studentIds'), 
                        DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                        DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schools.id)) as parentIds'), 
                        DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),

                    )
                    ->where('county_id', $county_id)
                    ->get();
        // return $schools;
        $county = DB::table('counties')->where('id', $county_id)->select('county_name')->first();
        return view('Admin.counties.counties-detail', compact('schools','admin','county'));
        dd($county_id);

    }
}
