<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\SendInvitation;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('County.auth.login');
    }

    public function countyLogin(Request $request)
    {
        if(Auth::guard('admin')->attempt(['email' => $request->email , 'password' => $request->password, 'role' => 'county']))
        {
            
            $county_admin = Auth::guard('admin')->user();
            $county_admin->device_token = $request->device_token;
            $county_admin->save();
            return redirect()->route('countyDashboard');
            
        }
        return redirect()->back()->withErrors(['msg' => 'Invalid Credentials']);

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('countyLoginForm');
    }

    public function registration($email , $code) 
    {
        
        $checkInviteStatus = SendInvitation::where(['email' => $email, 'code' => $code, 'status' => 'pending'])->firstOrFail();
        
        $states = State::get();
        return view('County.auth.register', compact('states','email'));
    }

    public function getProfile()
    {
        // return 'fad';
        return view('County.profile.index');
    }
}
