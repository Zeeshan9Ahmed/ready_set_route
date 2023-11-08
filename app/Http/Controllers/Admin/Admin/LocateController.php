<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocateController extends Controller
{
    public function getStateWiseCounty(Request $request)
    {
        $counties = DB::table('counties')->where('state_id', $request->state_id)->get();
        return json_encode($counties);
    }
    public function countiesSchool(Request $request)
    {
        $schools = DB::table('schools')
                        ->select(
                            'schools.id',
                            'schools.school_name'
                        )
                        ->where('county_id', 1)->get();
        return json_encode($schools);
    }

    public function schoolDrivers(Request $request)
    {
 
        $school_id = $request->school_id;
        $drivers = DB::select(
            'Select drivers.id,drivers.name  from drivers where id in ( select (driver_id) from school_drivers where school_drivers.school_id = '.$school_id.'   )'
        );
        return json_encode($drivers);

    }

    public function getDriversStudents(Request $request)
    {
        $driver_id = $request->driver_id;
        $driver_students = DB::select(
            'select users.id, users.name as student_name, users.latitude,longitude from users where users.role = "student" and users.driver_id = "'.$driver_id.'"'
        );

        return json_encode($driver_students);
    }
}
