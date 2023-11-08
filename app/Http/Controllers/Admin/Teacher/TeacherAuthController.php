<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SendInvitation;
use App\Models\State;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TeacherAuthController extends Controller
{
    public function loginForm()
    {
        return view('Teacher.auth.login');
    }

    public function teacherLogin(Request $request)
    {
        
        if(Auth::guard('teacher')->attempt(['email' => $request->email , 'password' => $request->password]))
        {
        
            $teacher_admin = Auth::guard('teacher')->user();
            $teacher_admin->device_token = $request->device_token;
            $teacher_admin->save();
            return redirect()->route('teacherDashboard');
        
        }
        return redirect()->back()->withErrors(['msg' => 'Invalid Credentials']);
        
    }

    public function logout()
    {
        if ( auth('teacher')->check() )
        {
            auth('teacher')->logout();
            return redirect()->route('teacherLoginForm');
        }

        return redirect()->route('teacherLoginForm');

    }
    public function registration($email, $code) 
    {
        $checkInviteStatus = SendInvitation::where(['email' => $email, 'code' => $code, 'status' => 'pending'])->firstOrFail();
        // return $checkInviteStatus;
        $school_id = $checkInviteStatus->sender_id;
        return view('Teacher.auth.register', compact('email','school_id'));
    }


    public function saveTeacher(Request $request)
    {
        $image = '';
        if ($request->hasFile('image')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            $image = asset('public/uploadedimages') . "/" . $imageName;
        }

        $data = [
            'school_id' => $request->school_id,
            'name' => $request->teacher_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $image,
        ];

        $teacher = Teacher::create($data);

        $invitations = SendInvitation::where('email', $request->email)->update(['status' => 'accept']);

        Auth::guard('teacher')->login($teacher, false);

        return redirect()->route('teacherDashboard');
        
    }
}
