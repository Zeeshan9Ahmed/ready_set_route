<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountyLocateController extends Controller
{
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
        $school_id = $request->school_id;
        
        $driver_students = DB::select(
            'select users.id, users.name as student_name, users.latitude,longitude from users where users.role = "student" AND users.driver_id = "'.$driver_id.'" AND users.school_id = "'.$school_id.'"'
        );
        return json_encode($driver_students);
    }
}
