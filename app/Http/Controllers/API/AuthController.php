<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\forgotPasswordOtpVerifyRequest;
use App\Http\Requests\Api\forgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\resetForgotPasswordRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class AuthController extends Controller
{
    //
    public function SignUp(Request $request)
    {

        $all = $request->all();
        $rules = [
            "email" => "required|email|unique:users,email",
            "password" => "required
            |min:6|required_with:confirm_password|same:confirm_password",
            "confirm_password" => "min:6",
            "role" => "required|in:student,driver,teacher,parent",

        ];

        $validator = Validator::make($all, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $role = $request->role;

        $image = $request->file("profile_image");
        if ($image) {

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($image->getClientOriginalExtension());
            $img_name = $name_gen . "." . $img_ext;
            $up_location = "profile/";
            $last_img = $up_location . $img_name;
            $image->move($up_location, $img_name);

        }

        //rand(100000, 999999);

        $user = new User();
        $user->otp = 123456;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $role;
        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token;
        $user->password = Hash::make($request->password);
        $user->image = $last_img ?? null;
        $user->remember_token = Str::random(10);
        $user->save();
        $token = $user->createToken("authToken")->plainTextToken;
        //$user->notify(new VerifyEmail($user));

        if ($user) {

            $vehicle = new Vehicle();
            $vehicle->user_id = $user->id;
            $vehicle->save();

            return response()->json([
                "status" => 1,
                "message" =>
                "We have sent OTP verification code at your email address",
                "data" => ["user_id" => $user->id],
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Something Went Wrong...!",
            ]);
        }
    }

    public function ResendOtp(Request $request)
    {

        $controls = $request->all();
        $rules = [
            "user_id" => "required|exists:users,id",
        ];
        $customMessages = [
            "required" => "The :attribute  is required.",
            "exists" => "The :attribute is Not Exists",
        ];
        $validator = Validator::make($controls, $rules, $customMessages);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }
        $user = User::where("id", "=", $request->user_id)->first();
        if ($user) {
            $user->otp = 123456;
            $user->save();
            //$user->notify(new VerifyEmail($user));

            return response()->json([
                "status" => 1,
                "message" =>
                "We have sent OTP verification code at your email address",
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Something Went Wrong",
            ]);
        }
    }

    public function Verification(Request $request)
    {

        $controls = $request->all();
        $rules = [
            "otp" => "required|min:6|numeric",
            "user_id" => "required|exists:users,id",
        ];
        $customMessages = [
            "required" => "The :attribute  is required.",
            "numeric" => "The :attribute  Must be Numeric",
            "exists" => "The :attribute is Not Exists",
        ];
        $validator = Validator::make($controls, $rules, $customMessages);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }
        $user = User::where([
            ["id", "=", $request->user_id],
            ["otp", "=", $request->otp],
        ])->first();
        if ($user) {
            $user = Auth::loginUsingId($user->id, true);
            $token = $user->createToken("authToken")->plainTextToken;
            $user->email_verified_at = Carbon::now();
            $user->account_verified = 1;
            $user->save();
            return response()->json([
                "status" => 1,
                "data" => $user,
                "message" =>
                "Account Verification Completed Successfully login...!",
                "bearer_token" => $token,
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Invalid OTP",
            ]);
        }
    }

    public function Login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->normalLogin($request);
        }

        if (Auth::guard('driver')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->driverLogin($request);
        }

        return commonErrorMessage("Invalid Credentials", 400);

    }

    protected function driverLogin($request)
    {

        $driver = Auth::guard('driver')->user();
        $driver->device_type = $request->device_type;
        $driver->device_token = $request->device_token;
        $driver->save();

        $driver->tokens()->delete();
        $token = $driver->createToken("driverToken")->plainTextToken;

        $driver = $this->driverData($driver->id);

        return apiSuccessMessage("Login Successfully", $driver, $token);

    }

    protected function driverData($driver_id)
    {
        return DB::table('drivers')
            ->select(
                'drivers.*'
            )
            ->selectRaw(' 0 as school_id')
            ->selectRaw(' 0 as parent_id')
            ->selectRaw(' 0 as driver_id')
            ->selectRaw(' 1 as account_verified')
            ->selectRaw(' null as email_verified_at')
            ->selectRaw(' null as user_social_token')
            ->selectRaw(' null as user_social_type')
            ->selectRaw(' 0 as notification')
        // ->selectRaw(' null as pick_time')
        // ->selectRaw(' null as drop_time')
            ->selectRaw(' "going" as status')
            ->whereId($driver_id)->first();
    }

    protected function normalLogin($request)
    {
        $user = Auth::user();
        
        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token;
        $user->save();
        $user->tokens()->delete();
        $token = $user->createToken("authToken")->plainTextToken;
        $user = $this->userData($user->id);
        return apiSuccessMessage("Login Successfully", $user, $token);
    }

    protected function userData($user_id)
    {
        return DB::table('users')
            ->select(
                'users.*'
            )
            ->selectRaw(' 1 as account_verified')
            ->selectRaw(' null as email_verified_at')
            ->selectRaw(' null as user_social_token')
            ->selectRaw(' null as user_social_type')
            ->selectRaw(' 0 as notification')
        // ->selectRaw(' null as pick_time')
        // ->selectRaw(' null as drop_time')
            ->selectRaw(' "going" as status')
            ->whereId($user_id)->first();
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return [
            "status" => 1,
            "message" => "Logout Successfully..."];
    }

    public function forgotPassword(forgotPasswordRequest $request)
    {
        $email = $request->email;
        $user_email = ($this->checkEmailExists('users', $email));
        $driver_email = ($this->checkEmailExists('drivers', $email));
        if (!$user_email && !$driver_email) {
            return commonErrorMessage("Selected email is invalid", 400);
        }

        $token = 123456;
        DB::table("password_resets")->insert([
            "email" => $email,
            "token" => $token,
            "type" => $user_email == true ? "user" : "driver",
            "created_at" => Carbon::now(),
        ]);

        return commonSuccessMessage("Password reset otp has been sent to your email address");
        // $user->notify(new ResetPassword($token));

    }

    protected function checkEmailExists($table_name, $email)
    {
        return collect(DB::select('select distinct count(*) as count from ' . $table_name . ' where email = "' . $email . '"'))->first()->count;
    }
    public function forgotPasswordOtpVerify(forgotPasswordOtpVerifyRequest $request)
    {

        $check_otp = DB::table("password_resets")
            ->where(["token" => $request->otp, "email" => $request->email])
            ->first();

        if (!$check_otp) 
            return commonErrorMessage("OTP Invalid", 400);
        
        $totalDuration = Carbon::parse($check_otp->created_at)->diffInHours(Carbon::now());
        if ($totalDuration > 1) 
            return commonErrorMessage("OTP Expired", 400);
        
        return commonSuccessMessage("Otp Verified");

    }

    public function resetForgotPassword(resetForgotPasswordRequest $request)
    {
        
        $check_otp = DB::table("password_resets")
            ->where(["token" => $request->otp, "email" => $request->email])
            ->first();
        
        if ($check_otp) {
            $totalDuration = Carbon::parse($check_otp->created_at)->diffInHours(
                Carbon::now()
            );
            if ($totalDuration > 1) {
                return response()->json([
                    "status" => 0,
                    "message" => "OTP Expired",
                ]);
            }
            $user = DB::table($check_otp->type=="user"?"users":"drivers")->where("email", $check_otp->email)->update(['password' =>  bcrypt($request->new_password)]);
            
            DB::table("password_resets")
                ->where(["token" => $request->otp, "email" => $request->email])
                ->delete();
            return response()->json([
                "status" => 1,
                "message" => "Password updated successfully!",
            ]);
        }
        return response()->json(["status" => 0, "message" => "OTP Invalid"]);
    }

    public function ChangePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return commonErrorMessage("Old password is incorrect", 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return commonSuccessMessage("Password updated successfully!");
    }

    public function UpdateProfile(UpdateProfileRequest $request)
    {

        $user = auth()->user();
        $role = auth()->user()->role;
        if ($request->hasFile('image')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            $user->image = asset('public/uploadedimages') . "/" . $imageName;
        }
        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->address) {
            $user->address = $request->address;
        }

        $user->save();

        return apiSuccessMessage("Profile updated successfully!", $role == 'driver' ? $this->driverData(auth()->id()) : $this->userData(auth()->id()));
    }

    public function socialAuth(Request $request)
    {
        $controls = $request->all();

        $rules = [
            "access_token" => "required",
            "provider" => "required|in:google,facebook,apple,phone",
            "device_type" => "required|in:android,ios",
        ];
        $validator = Validator::make($controls, $rules);
        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => $validator->errors()->all()[0],
            ]);
        }

        $auth = app("firebase.auth");
        $idTokenString = $request->input("access_token");

        try {
            $user = User::where([
                ["user_social_token", "=", $idTokenString],
                ["user_social_type", "=", $request->provider],
            ])->first();
            if (!$user) {
                $user = new User();
                $user->is_social = 1;
                $user->user_social_token = $idTokenString;
                $user->user_social_type = $request->provider;
                $user->email = $request->email;
                $user->profile_image = $request->photoURL;
                $user->phone = $request->phoneNumber;
                $user->first_name = $request->displayName;
            }

            if (!$user->account_verified) {
                $user->account_verified = 1;
                $user->email_verified_at = Carbon::now();
            }
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;
            $user->tokens()->delete();
            Auth::loginUsingId($user->id, true);
            $user->save();

            $id = $user->id;

            $userdata = User::where("id", "=", $id)->first();
            $token = $user->createToken("authToken")->plainTextToken;

            return response()->json([
                "status" => 1,
                "message" => "Login Successful",
                "data" => $userdata,
                "bearer_token" => $token,
            ]);
        } catch (\InvalidArgumentException$e) {
            // If the token has the wrong format
            return response()->json([
                "status" => 0,
                "message" =>
                'Unauthorized - Can\'t parse the token: ' .
                $e->getMessage(),
            ]);
        } catch (InvalidToken $e) {
            // If the token is invalid (expired ...)
            return response()->json([
                "status" => 0,
                "message" =>
                "Unauthorized - Token is invalide: " . $e->getMessage(),
            ]);
        }

    }

}
