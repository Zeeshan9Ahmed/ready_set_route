<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolLocateController extends Controller
{
    public function getDriversStudents(Request $request)
    {
        $driver_id = $request->driver_id;
        
        $driver_students = DB::select(
            'select users.id, users.name as student_name, users.latitude,longitude from users where users.role = "student" AND users.driver_id = "'.$driver_id.'" AND users.school_id = "'.auth('school')->id().'"'
        );
        return json_encode($driver_students);
    }
}
