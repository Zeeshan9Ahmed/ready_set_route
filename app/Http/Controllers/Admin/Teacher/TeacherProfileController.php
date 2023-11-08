<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class TeacherProfileController extends Controller
{
    public function getProfile()
    {
        return view('Teacher.profile.index');
    }

    public function DashboardUpdateProfile(Request $request)
    {
        
        if ( $request->exists('user_name') )
        {
            auth('teacher')->user()->name = $request->user_name;
        }

        if ( $request->exists('phone') )
        {
            auth('teacher')->user()->phone = $request->phone;
        }

       
        if ($request->hasFile('image')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            auth('teacher')->user()->image = asset('uploadedimages') . "/" . $imageName;
        }
        
        auth('teacher')->user()->save();
        
        return redirect()->back()->with('success', 'Your profile updated successfully...');
    }

    public function changePassword(Request $request)
    {
        $new_password = $request->new_password;
        if ( $new_password != $request->confirm_password )
        {
            return redirect()->back()->withErrors(['msg' => 'Password Does Not Match...']);
        }

        auth('teacher')->user()->password = bcrypt($new_password);
        auth('teacher')->user()->save();
        return redirect()->back()->with('success', 'Password updated successfully...');

    }
    public function ChangeImage(Request $request)
    {
      
      if ($request->hasFile('image')) {
          $uuid = Str::uuid();
          $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
          $request->file('image')->move(public_path('/uploadedimages'), $imageName);
          auth('teacher')->user()->image = asset('public/uploadedimages') . "/" . $imageName;
          auth('teacher')->user()->save();
  
      }
          
          return back()->with('success', 'Image Updated Successfully...');
      }
}
