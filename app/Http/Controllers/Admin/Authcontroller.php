<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\County;
use App\Models\School;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;

use App\Notifications\AdminPasswordResetNotification;
class Authcontroller extends Controller
{
     public function logout()
    {
        
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }


    public function login(){
        return view('dashboard.auth.login');
    }

    public function test()
    {
 
            $data = [
                'total_states' => State::count(),
                'total_counties' => County::count(),
                'total_schools' => School::count(),
                'total_teachers' => Admin::where('role','teacher')->count(),
                'total_parents' => User::where('role','parent')->count(),
                'total_students' => User::where("role","student")->count(),
                'total_drivers' => User::where("role","driver")->count()
            ];
             dd($data, auth('admin')->user()->id);
    }

    public function login_process(Request $request)
    {

        if(Auth::guard('admin')->attempt(['email' => $request->email , 'password' => $request->password, 'role' => 'admin']))
        {
            // return $request->all();
            $admin = Auth::guard('admin')->user();
            $admin->device_token = $request->device_token;
            $admin->save();
            return redirect()->route('admin-dashboard');
        }
        return redirect()->back()->withErrors(['msg' => 'Invalid Credentials']);
        
    }
    
    
    
    public function forgot(){
       return view('dashboard.auth.forget-password');
    }
    
    
    public function forgotPassword(Request $request){
        $controls=$request->all();
        $rules=array(
            'email'=>'required|email|exists:users,email'
        );
        $customMessages = [
        'required' => 'The :attribute  is required.',
        'exists' => 'The :attribute is Not Exists',
        ];
        $validator=Validator::make($controls,$rules,$customMessages);
        if ($validator->fails()){
             return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
            
            $user = User::where('email',$request->email)->first();
            $token = rand(100000,999999);
            $user->password=bcrypt($token);
            $user->save();
            $user->notify(new AdminPasswordResetNotification($token));
            return redirect()->back()->withSuccess('Password reset otp has been sent to your email address');
      

    }
public function profile(){
        return view('dashboard.auth.profile');
    }
    
    
     public function updateadmin(Request $request){ 
         $admin= Auth::user();

         $controls=$request->all();
         $rules=array(
            "email"=>"required|email|unique:users,email,".$admin->id,
            "name"=>"required",
            "image"  => 'nullable',
        );
        $validator=Validator::make($controls,$rules);
        if ($validator->fails()) {
           
        return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = User::find($admin->id);
        $user->email =$request->email;
       
        $user->name=$request->name;
        if(isset($request->password) && isset($request->change_password)){
        $user->password= bcrypt($request->password);
        }
        if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('/uploadedimages/'), $imageName);
        $user->profile_image=$imageName;
        }
        if($user->save()){
          return redirect()->back()->withSuccess('Profile Updated Succefully...!');
        }else{
        return redirect()->back()->withErrors(['error'=>'Something Went Wrong...!']);
        }
    }
    
}