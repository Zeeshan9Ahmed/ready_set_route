<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function schoolsReport()
    {
        return view('Admin.reports.schools.index');
    }

    public function busesReport()
    {
        return view('Admin.reports.buses.index');
    }

    public function attendanceReport()
    {
        return view('Admin.reports.attendance.index');
    }

    public function delaysReport($is_unread_notification = 0)
    {
        if($is_unread_notification) {
            auth('admin')->user('admin')->show_notification_red_dot = 0;
            auth('admin')->user('admin')->save();
        }
        // return $is_unread_notification;
        // return Notification::where('title',"Bus Delay")->get();
        //Driver Name // Bus Number // School Name //County // Date // Time // Reason
        $delays = collect(DB::select('select  
                                notifications.id as notification_id,
                                vehicles.id as v_id,
                                drivers.name as driver_name,
                                schools.school_name as school_name,
                                counties.county_name as county_name,
                                vehicles.vehicle_number as vehicle_number,
                                DATE_FORMAT(notifications.created_at,"%D %M, %Y") as date,
                                TIME_FORMAT(notifications.created_at, "%h:%i %p") as time,
                                SUBSTRING_INDEX(notifications.description," said ", -1) as reason 
                                    from 
                                notifications 
                                join drivers ON drivers.id = user_id
                                left join vehicles ON vehicles.user_id = notifications.user_id
                                join schools ON schools.id = school_id
                                join counties ON counties.id = schools.county_id
                                where notification_type ="Bus Delay" GROUP BY notifications.id ORDER BY notifications.id DESC'));
        // return $delays;
        return view('Admin.reports.delays.index', compact('delays'));
    }

    public function financialReport()
    {
        return view('Admin.reports.financial.index');
    }

    public function travelReport()
    {
        return view('Admin.reports.travel.index');
    }

    public function getFilterType(Request $request)
    {
        $data = [];
        $type = $request->type;
        if ($type == "state") {
            $data = DB::table('states')->select('id', 'state_name as name')->get();
        }
        if ($type == "county") {
            $data =  DB::table('counties')->select('id', 'county_name as name')->get();
        }
        if ($type == "school") {
            $data =  DB::table('schools')->select('id', 'school_name as name')->get();
        }
        return response()->json([
            "status" => 1,
            "message" => "Data!",
            "data" => $data,
        ]);
    }

    public function getFilteredDrivers(Request $request)
    {
        $type = $request->type;
        $filter_type = $request->filter_type;
        $type_id  = $request->type_id;
        $where = "";
        if ($type == "state") {
            $where = "(SELECT driver_id FROM school_drivers WHERE school_drivers.school_id IN 
            (SELECT id from schools WHERE schools.county_id IN 
            (SELECT id from counties WHERE counties.state_id = $type_id)))  GROUP BY drivers.id  )";
        }

        if ($type == "county") {
            $where = "(SELECT driver_id FROM school_drivers WHERE school_drivers.school_id IN 
            (SELECT id from schools WHERE schools.county_id = $type_id))  GROUP BY drivers.id  )";
        }

        if ($type == "school") {
            $where = "(SELECT driver_id FROM school_drivers WHERE school_drivers.school_id = $type_id)  GROUP BY drivers.id )";
        }

        $data = DB::select('(SELECT 
                                    drivers.id,
                                    name, 
                                    email,
                                    vehicle_model,
                                    vehicle_mileage,
                                    vin_number,
                                    vehicle_number,
                            (SELECT CONCAT(
                                        DATE_FORMAT(date_sub(now(),INTERVAL 1 ' . $filter_type . '), "%D %M %Y") , " to " , DATE_FORMAT(now(), "%D %M %Y")
                                    )
                                 ) AS date, 
                            (SELECT sum(total_distance)  
                            from driver_daily_distances 
                                    where 
                            created_at between 
                                        date_sub(now(),INTERVAL 1 ' . $filter_type . ') and now()
                                        And 
                                        driver_daily_distances.driver_id = drivers.id) 
                                    as 
                                    total_distance, 
                            (SELECT sum(total_price)  
                            from driver_daily_distances 
                                    where 
                            created_at between 
                                        date_sub(now(),INTERVAL 1 ' . $filter_type . ') and now() 
                                        And 
                                        driver_daily_distances.driver_id = drivers.id) 
                                    as total_price
                            FROM drivers 
                            left join vehicles ON vehicles.user_id = drivers.id
                            WHERE drivers.id IN 
                                ' . $where . ' ');

        return response()->json([
            "status" => 1,
            "message" => "Success!",
            "data" => $data,
        ]);
    }

    public function filterDriversStateCountySchoolWise(Request $request)
    {
        return $request->all();
    }
}
