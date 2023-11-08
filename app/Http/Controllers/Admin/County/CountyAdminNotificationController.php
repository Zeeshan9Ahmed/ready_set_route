<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\Notification\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountyAdminNotificationController extends Controller
{
    public function notifications()
    {
        // return auth('admin')->id();
        $notifications = DB::table('notifications')
            ->select(
                'id',
                'user_id',
                'title',
                'description',
                'created_at',
            )
            ->selectRaw('
                            (CASE
                            WHEN sender_type = "admin" THEN (  (select admins.name from admins where id = notifications.user_id )   )
                            WHEN sender_type = "teacher" THEN (  (select teachers.name from teachers where id = notifications.user_id )   )
                            WHEN sender_type = "user" THEN (  (select users.name from users where id = notifications.user_id )   )
                            WHEN sender_type = "school" THEN (  (select schools.name from schools where id = notifications.user_id )   )
                            WHEN sender_type = "driver" THEN (  (select drivers.name from drivers where id = notifications.user_id )   )

                            ELSE ""
                            END

                            ) as name

                            ')
            ->selectRaw('
                            (CASE
                            WHEN sender_type = "admin" THEN (  (select admins.image from admins where id = notifications.user_id )   )
                            WHEN sender_type = "teacher" THEN (  (select teachers.image from teachers where id = notifications.user_id )   )
                            WHEN sender_type = "user" THEN (  (select users.image from users where id = notifications.user_id )   )
                            WHEN sender_type = "school" THEN (  (select schools.image from schools where id = notifications.user_id )   )
                            WHEN sender_type = "driver" THEN (  (select drivers.image from drivers where id = notifications.user_id )   )

                            ELSE ""
                            END

                            ) as image
                            ')
            ->where('reciever_type', 'county')->orderByDesc('id')->get();
        // return $this->getCountyUsers();
        return view('County.notifications.index', compact('notifications'));
    }

    public function send(Request $request)
    {

        $type = $request->type;
        $data = [
            'user_id' => auth('admin')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'sender_type' => 'county',
        ];

        $users = $this->getTokenswithType()->whereNotNull('device_token');


        if ($type == 'all') {
            Notification::create($data + ['reciever_type' => 'school']);
            Notification::create($data + ['reciever_type' => 'teacher']);
            Notification::create($data + ['reciever_type' => 'driver']);
            Notification::create($data + ['reciever_type' => 'parent']);
            Notification::create($data + ['reciever_type' => 'student']);
            $tokens = $users
                        ->pluck('device_token')
                        ->toArray();

        }

      
        if ($type == 'school') {
            Notification::create($data + ['reciever_type' => 'school']);

            $tokens = $users
                        ->where('role','school')
                        ->pluck('device_token')
                        ->toArray();
        }

        if ($type == 'teacher') {
            Notification::create($data + ['reciever_type' => 'teacher']);
            $tokens = $users
                        ->where('role','teacher')
                        ->pluck('device_token')
                        ->toArray();
        }

        if ($type == 'driver') {
            Notification::create($data + ['reciever_type' => 'driver']);
            $tokens = $users
                            ->where('role','driver')
                            ->pluck('device_token')
                            ->toArray();
        }

        if ($type == 'parent') {
            Notification::create($data + ['reciever_type' => 'parent']);
            $tokens = $users
                        ->where('role','parent')
                        ->pluck('device_token')
                        ->toArray();
        }

        if ($type == 'student') {
            Notification::create($data + ['reciever_type' => 'student']);
            $tokens = $users
                        ->where('role','student')
                        ->pluck('device_token')
                        ->toArray();
        }
        app(PushNotificationService::class)->execute($data, $tokens);

        return redirect()->back()->with('success', 'Sent Sucessfully');
    }

    public function getCountyUsers()
    {
        return collect(DB::select('
        (SELECT id , device_token , "school" as role FROM schools WHERE invited_by = "'.auth('admin')->id().'"  )
        UNION ALL
        (SELECT id , device_token , "student" as role FROM users where school_id IN (select id from schools where invited_by = "'.auth('admin')->id().'"  ) AND users.role = "student" )
        UNION ALL 
        ( SELECT id , device_token , "parent" as role FROM users where id IN ( SELECT parent_id  FROM users where school_id IN (select id from schools where invited_by = "'.auth('admin')->id().'"  ) AND users.role = "student" ) AND users.role = "parent" )
        UNION ALL
        (SELECT id , device_token, "driver" as role FROM drivers WHERE id IN ( select driver_id from school_drivers where school_id IN ( select id from schools where invited_by = "'.auth('admin')->id().'" ) )   );
        
        '));
    }
    

}
