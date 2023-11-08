<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\School;
use App\Services\Notification\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherAdminNotificationController extends Controller
{
    public function notifications()
    {
        $data = DB::table('notifications')
            ->select(
                'id',
                'user_id',
                'sender_type',
                'title',
                'description',
                'created_at',
            )
            ->selectRaw('
                            (CASE
                            WHEN sender_type = "admin" THEN (  (select admins.name from admins where id = notifications.user_id )   )
                            WHEN sender_type = "teacher" THEN (  (select teachers.name from teachers where id = notifications.user_id )   )
                            WHEN sender_type = "county" THEN (  (select admins.name from admins where id = notifications.user_id )   )
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
                            WHEN sender_type = "county" THEN (  (select admins.image from admins where id = notifications.user_id )   )
                            WHEN sender_type = "school" THEN (  (select schools.image from schools where id = notifications.user_id )   )
                            WHEN sender_type = "driver" THEN (  (select drivers.image from drivers where id = notifications.user_id )   )

                            ELSE ""
                            END

                            ) as image
                            ')
            ->where('reciever_type', 'teacher')
            ->get();

        $school_id = auth('teacher')->user()->school_id;
        $county_id = School::find($school_id)?->invited_by;
        // return $county_id;
        $notifications = [];
        foreach ($data as $notification) {
            if ($notification->sender_type == "county" && $notification->user_id == $county_id) {
                $notifications[] = $notification;
            }

            if ($notification->sender_type == "school" && $notification->user_id == $school_id) {
                $notifications[] = $notification;

            }

            if ($notification->sender_type == "admin") {
                $notifications[] = $notification;
            }
        }

        $notifications = collect($notifications)->sortBy([['id', 'desc']])->values();

        // return $this->getSchoolUsers();

        return view('Teacher.notifications.index', compact('notifications'));
    }

    public function send(Request $request)
    {

        $type = $request->type;
        $data = [
            'user_id' => auth('teacher')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'sender_type' => 'teacher',
        ];

        $users = $this->getSchoolUsers()->whereNotNull('device_token');
        $tokens = "";
        if ($type == 'all') {
            Notification::create($data + ['reciever_type' => 'parent']);
            Notification::create($data + ['reciever_type' => 'student']);

            $tokens = $users
                ->pluck('device_token')
                ->toArray();
        }

        if ($type == 'parent') {
            Notification::create($data + ['reciever_type' => 'parent']);
            $tokens = $users
                ->where('role', 'parent')
                ->pluck('device_token')
                ->toArray();
        }

        if ($type == 'student') {
            Notification::create($data + ['reciever_type' => 'student']);
            $tokens = $users
                ->where('role', 'parent')
                ->pluck('device_token')
                ->toArray();
        }

        app(PushNotificationService::class)->execute($data, $tokens);

        return redirect()->back()->with('success', 'Sent Sucessfully');
    }

    public function getSchoolUsers()
    {
        return collect(DB::select('
        (SELECT id , device_token , "student" as role FROM users where school_id IN ( "' . auth('teacher')->user()->school_id . '"  ) AND users.role = "student" )
        UNION ALL
        ( SELECT id , device_token , "parent" as role FROM users where id IN ( SELECT parent_id  FROM users where school_id IN ( "' . auth('teacher')->user()->school_id . '"  ) AND users.role = "student" ) AND users.role = "parent" )
        '));
    }
}
