<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateDriverRequest;
use App\Models\Driver;
use App\Models\School;
use App\Models\SchoolDriver;
use App\Models\SendInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function schoolForm($school_id)
    {

        return view('School.school.create-school', compact('school_id'));
    }

    public function registerSchoolAdmin(Request $request)
    {
        $image = '';
        if ($request->hasFile('image')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            $image = asset('public/uploadedimages') . "/" . $imageName;
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'county_id' => $request->county_id,
            'invited_by' => $request->invited_by,
            'password' => bcrypt($request->password),
            'image' => $image,
        ];

        $school_id = School::create($data)->id;

        $invitations = SendInvitation::where('email', $request->email)->update(['status' => 'accept']);
        return redirect(url("sub-admin-school/school/register/$school_id"));

    }

    public function saveSchool(Request $request)
    {
        
        $id = $request->school_id;
        $school = School::findOrFail($id);

        $image = '';
        if ($request->hasFile('image')) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('/uploadedimages'), $imageName);
            $image = asset('public/uploadedimages') . "/" . $imageName;
        }

        $school->school_name = $request->school_name;
        $school->school_image = $image;
        $school->school_phone = $request->phone;
        $school->address = $request->address;
        $school->latitude = $request->latitude;
        $school->longitude = $request->longitude;
        $school->description = $request->description;
        $school->save();

        Auth::guard('school')->login($school, false);

        return redirect()->route('schoolDashboard');
    }

    public function createDriver()
    {
        // return 'create';
        return view('School.drivers.create-driver');
    }

    public function saveDriver(CreateDriverRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => 'driver',
        ];

        $driver_id = Driver::create($data)->id;
        SchoolDriver::create([
            'school_id' => auth('school')->id(),
            'driver_id' => $driver_id,
            'status' => 'created',
        ]);
        return redirect()->route('school-admin-drivers');

    }
}
