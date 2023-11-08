<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\County;
use App\Models\SendInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CountyController extends Controller
{
    public function getStateWiseCounty(Request $request)
    {
        $counties = DB::table('counties')->where('state_id', $request->state_id)->where('admin_id',NULL)->get();
        return json_encode($counties);
    }

    public function registerCounty(Request $request)
    {
        $admin = Admin::where('email', $request->email)->firstOrFail();
        
        $admin->name = $request->user_name;
        $admin->phone = $request->phone;
        $admin->password = bcrypt($request->password);
        
        $image = '';
        if($request->hasFile('image'))
        {
            $uuid = Str::uuid();
            $imageName = $uuid.time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            $image = asset('public/uploadedimages')."/".$imageName;
        }
        $admin->image = $image;
        $admin->save();
        
        SendInvitation::where('email', $admin->email)->update(['status' => 'accepted']);
        
        Auth::guard('admin')->login(Admin::find($admin->id),true);
        
        return redirect()->route('countyDashboard');
        
    }
}
