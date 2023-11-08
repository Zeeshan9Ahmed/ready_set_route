<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceStatus;
use App\Http\Requests\Api\CalendarRequest;
use App\Http\Requests\Api\GetParentsRequest;
use App\Http\Requests\Api\ParentSchoolDataRequest;
use App\Http\Requests\Api\SchoolProfileRequest;
use App\Http\Requests\Api\StartTimeRequest;
use App\Http\Requests\Api\StudentNotGoingRequest;
use App\Http\Requests\GetStudentsInSchool;
use App\Models\Driver;
use App\Models\Ort;
use App\Models\School;
use App\Models\User;
use App\Services\Notification\PushNotificationService;
use Auth;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Validator;

use function PHPUnit\Framework\returnSelf;

class SchoolController extends Controller
{
    //
    public function updateSchoolStatus (Request $request) {
        $user_ids = User::where(['school_id' => $request->school_id, 'driver_id' => auth()->id()])->pluck('id');
        $data = Ort::whereDate('date', getCurrentDate())->where('status', 'enRoute')->whereIn('user_id', $user_ids);
        //Get Students Which are at School For Today's Date and send the notification to Their parents for reaching school
        $student_ids = $data->pluck('user_id');
        if ($student_ids->count() >0) {
            //Update Students status to Reach At School
            $data->update(['status' => 'toSchool']);

            $students = User::whereIn('id', $student_ids)->get(['parent_id','name']);

            
            $parent_tokens = User::whereIn('id', $students->pluck('parent_id'))->whereNotNull('device_token')->get(['id', 'device_token']);
            foreach (collect($students) as $key => $student) {
                $notification_data['title'] = "$student->name has arrived at school!";
                $parent_token = $parent_tokens->where('id', $student->parent_id)->first()?->device_token;
                ($parent_token)?(app(PushNotificationService::class)->execute($notification_data, [$parent_token])):"";
                
            }
            return commonSuccessMessage("Success");
        }
        return commonSuccessMessage("Already Notified",400);
    }
    public function StudentGoing(Request $request)
    {

        $status = '';
        
        if ($request->status == 1) {
            $status = 'notgoing';
        } elseif ($request->status == 2) {
            $status = 'waiting';
        } elseif ($request->status == 3) {
            $status = 'toHome';
        } elseif ($request->status == 4) {
            $status = 'toSchool';
        } elseif ($request->status == 5) {
            $status = 'enRoute';
        } elseif ($request->status == 6) {
            $status = 'droppedOff';
        } elseif ($request->status == 7) {
            $status = 'absent';
        }

        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $begin = new DateTime($startdate);
        $end = new DateTime($enddate);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $id = $request->user_id;
        $dates = [];
        // return $period;
        foreach ($period as $dt) {

            DB::table('orts')->insert([
                'date' => $dt->format("Y-m-d "),
                'status' => $status,
                "user_id" => $id,
            ]);
        }

        return response()->json([
            "status" => 1,
            "message" => "students status update",

        ]);
    }

    public function Calender(CalendarRequest $request)
    {
        $users = Ort::where('user_id', $request->children_id)->get();

        if ($users->isEmpty())
            return commonErrorMessage("record not list", 400);

        return apiSuccessMessage("children list", $users);
    }

    public function ChildrenList(Request $request)
    {

        $data = $request->all();

        $rules = [
            "parent_id" => "required",

        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $parent_id = $request->parent_id;

        $user = user::with("student_attendance_status:user_id,status,date")->where("parent_id", $parent_id)->get();

        return response()->json([
            "status" => 1,
            "message" => "children list",
            "data" => $user,
        ]);
    }

    public function GetParents(GetParentsRequest $request)
    {

        $data =  User::with('parent_school', 'childrens')
            ->select('*')
            ->selectRaw(' ' . (int) ($request->school_id) . ' as school_id')
            ->whereRaw('id in 
                  ( select parent_id from users 
                  where 
                  (users.driver_id = "' . auth()->id() . '" AND users.school_id = "' . $request->school_id . '" ) 
                  AND 
                  users.role = "student" ) 
                  ')
            ->get();

        if ($data->count() == 0)
            return commonErrorMessage("Not Found", 400);

        return apiSuccessMessage("Parents List", $data);
    }

    public function GetStudents(GetStudentsInSchool $request): JsonResponse
    {

        if (auth()->user()->role == 'driver')
            return apiSuccessMessage("students list data ", $this->getDriverStudentsInSchool($request->school_id));


        if (auth()->user()->role == 'parent')
            return apiSuccessMessage("students list data ", $this->getParentChildsInSchool($request->school_id));
    }

    protected function getDriverStudentsInSchool($school_id): Collection
    {
        return User::with('school:id,school_name', 'driver:id,name', "student_attendance_status:user_id,status,date")
            ->where(['school_id' => $school_id, 'driver_id' => auth()->id(), 'role' => 'student'])
            ->get();
    }

    protected function getParentChildsInSchool($school_id): Collection
    {
        return User::with('school:id,school_name', 'driver:id,name', "student_attendance_status:user_id,status,date")
            ->where(['school_id' => $school_id, 'parent_id' => auth()->id(), 'role' => 'student'])
            ->get();
    }

    public function AllSchools()
    {
        if (auth()->user()->role == 'driver')
            return apiSuccessMessage("Schools Data ", $this->getDriverSchools());


        if (auth()->user()->role == 'parent')
            return apiSuccessMessage("Schools Data ", $this->getParentSchools());
    }

    protected function getDriverSchools()
    {
        return collect(DB::select('select
                                      id,
                                      school_name,
                                      school_image,
                                      school_phone as phone,
                                      address,
                                      latitude,
                                      longitude,
                                      description,
                                      created_at,
                                      updated_at
                                      from schools
                                      where id in
                                      (select school_id from school_drivers
                                       where driver_id = "' . auth()->id() . '")
                                '));
    }

    protected function getParentSchools()
    {
        return collect(DB::select('select
                                    id,
                                    school_name,
                                    school_image,
                                    school_phone as phone,
                                    address,
                                    latitude,
                                    longitude,
                                    description,
                                    created_at,
                                    updated_at
                                    from schools
                                    where id in
                                    ( select school_id from users
                                    where parent_id = "' . auth()->id() . '"
                                    AND
                                    users.role = "student" )
                                    '));
    }
    public function ParentSchools()
    {

        $parent_id = Auth::user()->id;
        $ids = User::where("parent_id", $parent_id)->get("school_id");
        $gara = [];
        foreach ($ids as $row) {
            $gara[] = $row->school_id;
        }

        $data = School::whereIn("id", $gara)->get();

        if (count($data) > 0) {
            return response()->json([
                "status" => 1,
                "message" => "all schools data",
                "data" => $data,
            ]);
        }
        return response()->json([
            "status" => 0,
            "message" => "record not found...!",

        ]);
    }

    public function StudentNotGoing(StudentNotGoingRequest $request)
    {
        $date = Carbon::parse($request->date);

        if ($date->isSaturday() || $date->isSunday())
            return commonErrorMessage("Please Select another date, It's Weekend", 400);

        $status = config('readysetroute.student_attendance_status')[$request->status];
        
        $user = User::find($request->user_id);
        
        Ort::updateOrCreate(['date' => $date, 'user_id' => $request->user_id], ['status' => $status]);

        if ($status == "enRoute") {
            $message = "$user->name has been picked up!";
        }

        if ($status == "droppedOff") {
            $message = "$user->name has arrived home!";
        }

        $formatedDate = $date->isoFormat('Do MMMM , YYYY');
        $common_message = "" . auth()->user()->name . " has changed the attendance status of $user->name  for date $formatedDate ";
        
        if (auth()->user()->role == 'driver') {
            
            $data['title'] = $message;
            $parent_token = User::find($user->parent_id)?->device_token;
            if ($parent_token) {
                app(PushNotificationService::class)->execute($data, $parent_token);
            }
        }

        if (auth()->user()->role == 'parent' && $date->isoFormat('YYYY-MM-DD') == getCurrentDate()) {
            $school_name = School::find($user->school_id)?->school_name;
            $data['title'] = "$user->name has been added to your $school_name bus Route!";
            $driver_token = Driver::find($user->driver_id)?->device_token;
            
            if ($driver_token) {
                app(PushNotificationService::class)->execute($data, $driver_token);
            }
            $data['title'] = "Your Driver is on their way!";
            app(PushNotificationService::class)->execute($data, $user?->device_token);
        }
        
        return commonSuccessMessage("Status Updated Successfully");
    }


    public function StartTime(StartTimeRequest $request)
    {

        //1 notgoing  //2 waiting //3 toHome   //4 toSchool    //5 enRoute    //6 droppedOff    //7  absent 
        $status = config('readysetroute.student_attendance_status');
        $student_ids = Ort::whereDate("date", "=", getCurrentDate())->whereNotIn('status', [$status[5], $status[6], $status[7], $status[1]])->pluck('user_id');
        $school_id = $request->school_id;
        
        $data = User::with(
            ["student_attendance_status" => function ($q) use($status) {
                $q->whereNotIn('status', [$status[5], $status[6], $status[7], $status[1]]);
            }]
        )
            ->where(["school_id" => $school_id, "role" => "student", 'driver_id' => auth()->id()])
            ->whereIn('id', $student_ids)
            ->get(["id", "name", "latitude", "longitude"]);

        if ($data->count() == 0)
            return commonErrorMessage("Students not found!", 400);


        return apiSuccessMessage("Students are comming", $data);
    }

    public function ParentSchoolData(ParentSchoolDataRequest $request)
    {

        $students = User::with("student_attendance_status")
            ->where([
                "parent_id" => auth()->id(),
                "school_id" => $request->school_id,
                "role" => "student"
            ]);

        $drivers = Driver::with("vehicle")->whereIn('id', $students->pluck('driver_id')->toArray())->get();

        return response()->json([
            "status" => 1,
            "message" => "drivers and childrens",
            "data" => [
                "drivers" => $drivers,
                "childrens" => $students->get(),
            ],
        ]);
    }

    public function SchoolProfile(SchoolProfileRequest $request)
    {

        $role = auth()->user()->role;

        $students = User::with('student_attendance_status', 'school', 'driver:id,name')
            ->where([
                'school_id' => $request->school_id,
                $role == "parent" ? "parent_id" : "driver_id" => auth()->id()
            ]);
        // ->get();
        if ($students->count() == 0)
            return commonErrorMessage("No Data Found", 400);

        return apiSuccessMessage("School Data", $students->get());
        // return $students;
        $school_id = $request->school_id;

        $school = School::with("childrens.student_attendance_status", "childrens.school", "childrens.driver:id,name")->where("id", "=", $school_id)->first();

        return response()->json([
            "status" => 1,
            "message" => "school data",
            "data" => $school,
        ]);
    }
}
