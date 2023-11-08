<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Content;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;

class AdminController extends Controller
{
    //
    public function DashboardUpdateProfile(Request $request)
    {
        
        if ( $request->exists('user_name') )
        {
            auth('admin')->user()->name = $request->user_name;
        }

        if ( $request->exists('phone') )
        {
            auth('admin')->user()->phone = $request->phone;
        }

       
        
        
        auth('admin')->user()->save();
        
        return redirect()->back()->with('success', 'Your profile updated successfully...');
    }


    public function changePassword(Request $request)
    {
        $new_password = $request->new_password;
        if ( $new_password != $request->confirm_password )
        {
            return redirect()->back()->withErrors(['msg' => 'Password Does Not Match...']);

            // return redirect()->back()->with('error', 'Password Does Not Match...');
        }

        auth('admin')->user()->password = bcrypt($new_password);
        auth('admin')->user()->save();

        return redirect()->back()->with('success', 'Password updated successfully...');

    }

  public function ChangeProfile(Request $request)
  {
    
    if ($request->hasFile('image')) {
        $uuid = Str::uuid();
        $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('/uploadedimages'), $imageName);
        auth('admin')->user()->image = asset('public/uploadedimages') . "/" . $imageName;
        auth('admin')->user()->save();

    }
        
        return back()->with('success', 'Image Updated Successfully...');
    }



    public function DashboardProfile()
    {
        return view('dashboard.auth.profile');
    }
    
    
    
}