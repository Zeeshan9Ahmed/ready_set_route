<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SendInvitation;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolAuthController extends Controller
{
    public function loginForm()
    {
        return view('School.auth.login');
    }

    public function schoolLogin(Request $request)
    {
        if(Auth::guard('school')->attempt(['email' => $request->email , 'password' => $request->password]))
        {
            $school_admin = Auth::guard('school')->user();
            $school_admin->device_token = $request->device_token;
            $school_admin->save();
            return redirect()->route('schoolDashboard');
        }

        return redirect()->back()->withErrors(['msg' => 'Invalid Credentials']);

    }

    public function logout(Request $request)
    {
        if ( auth('school')->check() )
        {
            auth('school')->logout();
            return redirect()->route('schoolLoginForm');
        }

    }

    public function registration($email , $code) 
    {
        
        $checkInviteStatus = SendInvitation::where(['email' => $email, 'code' => $code, 'status' => 'pending'])->firstOrFail();
        
        $county_id = Admin::find($checkInviteStatus->sender_id)->county_id;
        
        $invited_by = $checkInviteStatus->sender_id;
        
        
        return view('School.auth.register', compact('email', 'county_id', 'invited_by'));
    }


    public function getProfile()
    {
        return view('School.profile.index');
    }
}
