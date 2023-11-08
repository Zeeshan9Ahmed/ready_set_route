<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
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

       
        if ($request->hasFile('image')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            auth('admin')->user()->image = asset('uploadedimages') . "/" . $imageName;
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
        }

        auth('admin')->user()->password = bcrypt($new_password);
        auth('admin')->user()->save();
        return redirect()->back()->with('success', 'Password updated successfully...');

    }

    public function ChangeImage(Request $request)
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
}
