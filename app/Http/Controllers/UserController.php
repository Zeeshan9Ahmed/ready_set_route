<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ChildrentParentsRequest;
use App\Http\Requests\Api\ChildUpdatePDRequest;
use App\Http\Requests\Api\DailyAlertRequest;
use App\Http\Requests\Api\DelayBusRequest;
use App\Http\Requests\Api\DriverStatusRequest;
use App\Http\Requests\Api\ParentProfileRequest;
use App\Http\Requests\Api\SchoolInvitationRequest;
use App\Http\Requests\Api\StudentDriverDetailRequest;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Notification;
use App\Models\School;
use App\Models\SchoolDriver;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\Notification\PushNotificationService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function DriverStatus(DriverStatusRequest $request)
    {
        $status = $request->status;
        $message = "";
        if ($status == "no"){
            $message = "Bus Driver, ".auth()->user()->name." is not available today. Expect an update soon from your school or another driver for today!";
        }else {
            $message = "Bus Driver, ".auth()->user()->name." is available today!";
        }
        $data = [
            'user_id' => auth()->id(),
            'school_id' => $request->school_id,
            'title' => "Driver Status",
            'description' => $message,
        ];
        
        $students = User::where('school_id', $request->school_id)->get(['parent_id', 'device_token']);
        $parents_tokens = User::whereIn('id',$students->pluck('parent_id'))->pluck('device_token');
        $tokens = $students->pluck('device_token')->merge($parents_tokens)->filter()->values()->toArray();
        
        $data['title'] = $message;
        $send_push = app(PushNotificationService::class)->execute($data,$tokens);

       
        Notification::create($data);

        return commonSuccessMessage("Notified Successfully");
    }
    public function studentDriverDetail(StudentDriverDetailRequest $request)
    {

        $id = $request->student_id;

        $student = User::with('driver', 'driver.vehicle')->where('id', $id)->select('id', 'name', 'driver_id')->first();
        if (!$student) {
            return response()->json([
                "status" => 0,
                "message" => "Studnent Not Found...!",

            ]);
        }

        return response()->json([
            "status" => 1,
            "message" => "Student Driver Detail...!",
            "data" => $student,
        ]);

    }
    public function ChildUpdatePD(ChildUpdatePDRequest $request)
    {

        $user = User::find($request->child_id);

        if ($request->pick_time) {
            $user->pick_time = $request->pick_time;
        }

        if ($request->drop_time) {
            $user->drop_time = $request->drop_time;
        }

        if ($user->save()) {
            return apiSuccessMessage("children pick and drop updated successfully...!", $user);
        }

    }

    //   function store_info($id){
    //   return   Store::where("user_id",$id)->first("business_name");
    // }
    public function UpdateVehicle(Request $request)
    {

        $data = $request->all();

        $rules = [
            "vehicle_model" => "required",
            "vehicle_registration" => "required",
            "vehicle_type" => "required",
            "vehicle_mileage" => "required",
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $id = Auth::user()->id;

        $user = Vehicle::where("user_id", "=", $id)->first();
        if (!$user)
        {
            $user = new Vehicle();
            $user->user_id = $id;
        }

        if ($request->vehicle_model) {
            $user->vehicle_model = $request->vehicle_model;
        }
        if ($request->vehicle_registration) {
            $user->vehicle_registration = $request->vehicle_registration;
        }
        if ($request->vehicle_type) {
            $user->vehicle_type = $request->vehicle_type;
        }
        if ($request->vehicle_mileage) {
            $user->vehicle_mileage = $request->vehicle_mileage;
        }
        if ($request->vin_number) {
            $user->vin_number = $request->vin_number;
        }
        if ($request->vehicle_company) {
            $user->vehicle_company = $request->vehicle_company;
        }
        if ($request->vehicle_number) {
            $user->vehicle_number = $request->vehicle_number;
        }

        $added = $user->save();

        $data = User::with("vehicle", "schoolchildrens.school")->where("id", $id)->first();
        if ($added) {

            return response()->json([
                "status" => 1,
                "message" => "Vehicle updated successfully!",
                "data" => $data,
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }
    }
    public function ParentProfile(ParentProfileRequest $request)
    {

        $data = User::
            with(
            "childrens.student_attendance_status",
            "childrens.school:id,school_name",
            "childrens.driver.vehicle"
        )
            ->whereId($request->parent_id)
            ->first();

        return response()->json([
            "status" => 1,
            "message" => "parent profile data",
            "data" => $data,
        ]);
    }
    public function UserProfile(Request $request)
    {

        $data = $request->all();

        $rules = [
            "user_id" => "required",

        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $id = $request->user_id;

        $data = User::with("school", "driver", "driver.vehicle", "student_attendance_status:user_id,status,date")
            ->where("id", $id)->first();
        return response()->json([
            "status" => 1,
            "message" => "user profile data",
            "data" => $data,
        ]);
    }
    public function DriverProfile(Request $request)
    {
        $data = $request->all();

        $rules = [
            "driver_id" => "required",
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $id = $request->driver_id;

        $data = Driver::with("vehicle", "schoolchildrens.school")->where("id", $id)->first();

        return response()->json([
            "status" => 1,
            "message" => "driver profile data",
            "data" => $data,
        ]);
    }
    public function DailyAlerts(DailyAlertRequest $request)
    {
        if (auth()->user()->role == 'driver') {
            return commonErrorMessage("Record not found");
        }

        $delays = DB::table('bus_delays')->where('school_id', $request->school_id)->orderByDesc('id');

        if ($delays->count() == 0) {
            return commonErrorMessage("Record Not Found", 400);
        }

        return apiSuccessMessage("Record Found", $delays->get());

    }

    public function notifications()
    {
        $id = auth()->id();
        $role = auth()->user()->role;
        $school_admin_ids = "";
        $county_admin_ids = "";
        $teacher_ids = "";
        $notifications = collect([]);
        
        if ($role == 'driver') {
            $school_admin_ids = SchoolDriver::where(['driver_id' => $id , 'is_accepted' => 1])->pluck('school_id')->unique()->toArray();
            $county_admin_ids = School::whereIn('id', $school_admin_ids)->pluck('invited_by')->unique()->toArray();
            $teacher_ids = [];
            $notifications = $this->getDriverNotifications($id);
            
        }

        if ($role == 'parent') {
            $school_admin_ids =  User::where('parent_id', $id)->pluck('school_id')->unique()->toArray();
            $county_admin_ids = School::whereIn('id', $school_admin_ids)->pluck('invited_by')->unique()->toArray();
            $teacher_ids = Teacher::whereIn('school_id', $school_admin_ids)->pluck('id')->unique()->toArray();
            
            $notifications = $this->getParentNotifications($id);
        }

        if ($role == 'student') {
            $school_admin_ids = auth()->user()->school_id;
            $county_admin_ids = School::find($school_admin_ids)?->invited_by;
            $teacher_ids = [auth()->user()->created_by];

            $notifications = $this->getChildNotifications($id);
        }

        $notifications = $notifications
                            ->where('sender_type', "county")->whereIn('user_id', $county_admin_ids)
                            ->merge(
                                $notifications
                                    ->where('sender_type', "school")->whereIn('user_id', $school_admin_ids)
                            )
                            ->merge(
                                $notifications
                                    ->where('sender_type', "teacher")->whereIn('user_id', $teacher_ids)
                            )
                            ->merge(
                                $notifications 
                                        ->whereIn('sender_type', ['admin',''])
                            );
        return apiSuccessMessage("Notifications", $notifications->sortByDesc('created_at')->values());

    }

    protected function getParentNotifications($parent_id)
    {
        return collect(DB::select(" SELECT X.* from (SELECT notifications.id ,notifications.title, sender_type , user_id ,notifications.description , notifications.created_at FROM
        notifications WHERE (reciever_id = $parent_id ) OR (school_id in (SELECT school_id FROM users WHERE users.parent_id = $parent_id ) ) OR reciever_type = 'parent' UNION 
         (SELECT  orts.id , 'Student Attendace Status' as title , '' as  sender_type , '' as user_id , 
         (CASE 
            WHEN orts.status = 'waiting' THEN CONCAT((select  name from users where id = orts.user_id LIMIT 1) , ' waiting for driver ') 
            WHEN orts.status = 'enRoute' THEN CONCAT((select  name from users where id = orts.user_id LIMIT 1) , ' has been picked! ') 
            WHEN orts.status = 'toSchool' THEN CONCAT((select  name from users where id = orts.user_id LIMIT 1) , ' has arrived at school ! ') 
            WHEN orts.status = 'droppedOff' THEN CONCAT((select  name from users where id = orts.user_id LIMIT 1) , ' has arrived home! ') 
            END
        )
             as description, orts.created_at FROM
        orts
        where user_id IN (SELECT id FROM users WHERE users.parent_id = $parent_id)) ) X ORDER by X.created_at DESC "));
    }

    protected function getChildNotifications($child_id)
    {
        return collect(DB::select("  SELECT X.* from (SELECT notifications.id ,notifications.title,sender_type , user_id , notifications.description, notifications.created_at FROM
        notifications WHERE (reciever_id = $child_id ) OR (school_id in (SELECT school_id FROM users WHERE users.id = $child_id ) ) OR reciever_type = 'student' UNION 
         (SELECT  orts.id , 'Student Attendace Status' as title ,'' as  sender_type , '' as user_id , orts.status as description,  orts.created_at FROM
        orts
        where user_id = $child_id) ) X ORDER by X.created_at DESC "));
    }

    protected function getDriverNotifications($driver_id)
    {
        return collect(DB::select("  SELECT X.* from (SELECT notifications.id ,notifications.title,sender_type , user_id , notifications.description , notifications.created_at FROM
        notifications WHERE (user_id = $driver_id ) OR (school_id in (SELECT school_id FROM school_drivers WHERE school_drivers.driver_id = $driver_id AND is_accepted = 1 ) ) OR reciever_type = 'driver' UNION  
        (SELECT orts.id , 'Student Attendace Status' as title ,'' as  sender_type , '' as user_id , CONCAT((select  name from users where id = orts.user_id LIMIT 1) , ' has been added to your ', (select  school_name from schools where id = (select school_id from users where id = orts.user_id) LIMIT 1) ) as description, orts.created_at FROM
        orts
        where user_id IN (SELECT id FROM users WHERE users.driver_id = $driver_id )) ) X ORDER by X.created_at DESC "));
    }

    public function CAU(Request $request)
    {
        $data = $request->all();

        $rules = [
            "children_id" => "required",
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $data = User::find($request->children_id);

        $data->address = $request->address;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->save();
        return response()->json([
            "status" => 1,
            "message" => "record save successfully",
            'data' => $this->userData($data->id),
        ]);
    }

    public function userData($user_id)
    {
        return DB::table('users')
            ->select(
                'users.*'
            )
            ->selectRaw(' 1 as account_verified')
            ->selectRaw(' null as email_verified_at')
            ->selectRaw(' null as user_social_token')
            ->selectRaw(' null as user_social_type')
            ->selectRaw(' 0 as notification')
        // ->selectRaw(' null as pick_time')
        // ->selectRaw(' null as drop_time')
            ->selectRaw(' "going" as status')
            ->whereId($user_id)->first();
    }
    public function SchoolRequest()
    {

        $requests = DB::table('school_drivers')
            ->join('schools', 'schools.id', 'school_drivers.school_id')
            ->select(
                'school_drivers.id',
                'schools.school_name',
                DB::raw('( select  CONCAT(schools.school_name , " ", "has sent you a request ")  ) as description'),
                'school_drivers.created_at',
            )
            ->where(['driver_id' => auth()->id(), 'is_accepted' => 0])
            ->groupBy('school_drivers.school_id')
            ->get();

        if ($requests->isEmpty()) {
            return commonErrorMessage("record not found", 400);
        }

        return apiSuccessMessage("requests from schools", $requests);

    }
    public function SchoolInvitation(SchoolInvitationRequest $request)
    {
        $id = $request->request_id;
        $type = $request->type;
        $request = SchoolDriver::find($id);

        if ($request->driver_id != auth()->id()) {
            return commonErrorMessage("Can't accept or reject the request", 400);
        }

        if ($type == "reject") {
            return $this->rejectSchoolRequest($request->id);
        }

        return $this->acceptSchoolRequest($request->id);

    }

    protected function rejectSchoolRequest($reject_id)
    {
        if (DB::table('school_drivers')->where('id', $reject_id)->delete()) {
            return commonSuccessMessage("Request rejected Successfully");
        }
        return commonErrorMessage("Something Went wrong", 400);
    }

    protected function acceptSchoolRequest($reject_id)
    {
        if (DB::table('school_drivers')->where('id', $reject_id)->update(['is_accepted' => 1])) {
            return commonSuccessMessage("Request accepted Successfully");
        }
        return commonErrorMessage("Something Went wrong", 400);
    }
    public function Delay(DelayBusRequest $request)
    {
        $vehicle = Vehicle::where('user_id', auth()->id())->first();
        $number = $vehicle->vehicle_number??"0000";
        $message = "Bus #$number has experienced a delay.";
        $data = [
            'school_id' => $request->school_id,
            'user_id' => auth()->id(),
            'title' => 'Bus Delay',
            'notification_type' => 'Bus Delay',
            'description' => $message,
            'data' => $message,
        ];
        
        Notification::create($data);
        $message = auth()->user()->name . " said ".$request->message." ";
        $data['description'] = $message;
        $data['data'] = $message;
        Notification::create($data);
        School::whereId($request->school_id)->update(['show_notification_red_dot'=>1]);
        Teacher::where('school_id', $request->school_id)->update(['show_notification_red_dot' => 1]);
        Admin::whereId(1)->update(['show_notification_red_dot'=>1]);
        return commonSuccessMessage("Success");
    }

    public function Childrenparents(ChildrentParentsRequest $request)
    {
        $id = $request->children_id;
        $parent_id = User::find($id)->parent_id;

        $data = User::with(
            ['childrens' => function ($q) use ($id) {
                $q->where('id', '=', $id);
            },
                "childrens.student_attendance_status" => function ($q) use ($id) {
                    $q->where('user_id', '=', $id);
                },
            ])->where("id", $parent_id)
            ->first();

        if (!$data) {
            return commonErrorMessage("data not found", 400);
        }

        return apiSuccessMessage("data found", $data);

    }
}
