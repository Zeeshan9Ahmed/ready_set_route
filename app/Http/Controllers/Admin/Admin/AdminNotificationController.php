<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\Notification\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminNotificationController extends Controller
{
    public function notifications()
    {
        return view('Admin.notifications.index');
    }

    public function send(Request $request)
    {
        $type = $request->type;
        $data = [
            'user_id' => auth('admin')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'sender_type' => 'admin',
        ];
        $users = $this->getTokenswithType()->whereNotNull('device_token');


        $tokens = '';
        if ($type == 'all') {
            Notification::create($data + ['reciever_type' => 'county']);
            Notification::create($data + ['reciever_type' => 'school']);
            Notification::create($data + ['reciever_type' => 'teacher']);
            Notification::create($data + ['reciever_type' => 'driver']);
            Notification::create($data + ['reciever_type' => 'parent']);
            Notification::create($data + ['reciever_type' => 'student']);
            $tokens = $users
                ->where('role', 'admin')
                ->where('id', '!=', auth('admin')->id())
                ->pluck('device_token')
                ->toArray();

        }

        if ($type == 'county') {
            Notification::create($data + ['reciever_type' => 'county']);
            $tokens = $users
            ->where('role', 'county')
            ->pluck('device_token')
            ->toArray();
        }

        if ($type == 'school') {
            $tokens = $users
            ->where('role', 'school')
            ->pluck('device_token')
            ->toArray();
            Notification::create($data + ['reciever_type' => 'school']);
        }

        if ($type == 'teacher') {
            $tokens = $users
            ->where('role', 'teacher')
            ->pluck('device_token')
            ->toArray();
            Notification::create($data + ['reciever_type' => 'teacher']);
        }

        if ($type == 'driver') {
            $tokens = $users
            ->where('role', 'driver')
            ->pluck('device_token')
            ->toArray();
            Notification::create($data + ['reciever_type' => 'driver']);
        }

        if ($type == 'parent') {
            $tokens = $users
            ->where('role', 'parent')
            ->pluck('device_token')
            ->toArray();
            Notification::create($data + ['reciever_type' => 'parent']);
        }

        if ($type == 'student') {
            $tokens = $users
            ->where('role', 'student')
            ->pluck('device_token')
            ->toArray();
            Notification::create($data + ['reciever_type' => 'student']);
        }
        // return $tokens;
        app(PushNotificationService::class)->execute($data, $tokens);

        return redirect()->back()->with('success', 'Sent Sucessfully');
        
    }

    public function getTokenswithType()
    {
        $users = DB::select('(SELECT id , device_token, role as role FROM admins )
                    UNION ALL
                    (SELECT id , device_token , "teacher" as role FROM teachers   )
                    UNION ALL
                    (SELECT id , device_token , role as role FROM users  )
                    UNION ALL
                    (SELECT id , device_token, "school" as role FROM schools  )
                    UNION ALL
                    (SELECT id , device_token, "driver" as role FROM drivers  );
        ');
        return collect($users);
    }

}
