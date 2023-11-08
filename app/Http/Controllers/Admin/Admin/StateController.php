<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateNewCountyRequest;
use App\Http\Requests\Admin\CreateNewStateRequest;
use App\Http\Requests\Admin\EditCountyRequest;
use App\Http\Requests\Admin\EditStateRequest;
use App\Models\County;
use App\Models\School;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    public function stateDetail($state_id)
    {
        $state_counties_id = County::where('state_id',$state_id)->pluck('id');
        $schools = School::
                        whereIn('county_id', $state_counties_id)
                        ->select(
                            'schools.id',
                            'schools.school_name',
                            DB::raw('(select count(id) from teachers where teachers.school_id = schools.id ) as teacher_count'),
                            DB::raw('(select group_concat(driver_id) from school_drivers as sd where FIND_IN_SET(sd.school_id,schools.id)) as driverIds'), 
                            DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds) ) as driver_count'),
                            
                            DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.school_id,schools.id) AND upt.role = "student") as studentIds'), 
                            DB::raw('(select group_concat(parent_id) from users as upt where FIND_IN_SET(upt.school_id,schools.id)) as parentIds'), 
                            DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                            DB::raw('(select count(id) from users as up where FIND_IN_SET(up.id,parentIds) AND up.role = "parent") as parent_count'),                        
                            )
                    ->get();


        // return $schools;
        return view('Admin.states.state-detail', compact('schools'));
        
    }

    public function addState()
    {
        $states = DB::table('states')->select('id','state_name')->get();
        $counties = DB::table('counties')->select('id','county_name')->get();
        return view('Admin.states.create-state', compact('states','counties'));
    }

    public function saveState(CreateNewStateRequest $request)
    {
        State::create([
            'state_name' => $request->state_name,
        ]);
        return redirect()->back()->with('success', 'State Created Sucessfully');
        
    }

    public function saveCounty(CreateNewCountyRequest $request)
    {
        County::create($request->validated());
        return redirect()->back()->with('success', 'County Created Sucessfully');
    }

    public function getState($state_id)
    {
        $state = DB::table('states')->find($state_id);
        
        return view('Admin.states.edit-state',compact('state'));
    }

    public function getCounty($county_id)
    {
        $county = DB::table('counties')->find($county_id);
        return view('Admin.counties.edit-county',compact('county'));

    }


    public function editState(EditStateRequest $request)
    {
        DB::table('states')->where('id',$request->state_id)->update($request->validated());
        return redirect()->route('admin-add-state')->with('success','State Updated Sucessfully');
    }


    public function editCounty(EditCountyRequest $request)
    {
        DB::table('counties')->where('id',$request->county_id)->update($request->validated());
        return redirect()->route('admin-add-state')->with('success','County Updated Sucessfully');

        return redirect()->back();
        

    }
    
}
