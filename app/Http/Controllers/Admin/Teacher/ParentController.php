<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\AddParentRequest;
use App\Http\Requests\Teacher\AddStudentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function getParents()
    {
        // return auth('teacher')->id();
        $parents = DB::table('users')
            ->select(
                'users.id',
                'users.name as parent_name',
                'users.email',
                DB::raw('( select group_concat(id) from users as child where FIND_IN_SET (child.parent_id , users.id)  AND child.role = "student") as childIds'),
                DB::raw('( select group_concat(driver_id) from users as child where FIND_IN_SET (child.parent_id , users.id)  AND child.role = "student") as driverIds'),
                DB::raw('( select count(id) from users as st where FIND_IN_SET(st.id, childIds) AND st.role = "student" ) as total_childs'),
                DB::raw('( select count(id) from drivers  where FIND_IN_SET(drivers.id, driverIds) ) as total_drivers'),
            )
            ->where(['users.created_by' => auth('teacher')->id(), 'users.role' => 'parent'])
            ->get();
        // return $parents;
        return view('Teacher.parents.index', compact('parents'));
    }

    public function parentDetail($parent_id)
    {
        
        $children = DB::table('users')
                        ->join('teachers', 'teachers.id', 'users.created_by')
                        ->leftjoin('drivers', 'drivers.id', 'users.driver_id')
                        ->join('schools', 'schools.id', 'users.school_id')
                        ->select(
                            'users.id',
                            'users.name as child_name',
                            'users.email as child_email',
                            'teachers.name as teacher_name',
                            DB::raw('(if(drivers.name is null , "No Driver Assigned", drivers.name )) as driver_name'),
                            'schools.school_name'
                        )
                        ->where('users.parent_id', $parent_id)
                        ->get();
        
        return view('Teacher.parents.parent-detail', compact('children','parent_id'));
    }

    public function parentForm() 
    {
        return view('Teacher.parents.create-parent');
    }

    public function saveParent(AddParentRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => "parent",
            'latitude' =>  $request->latitude,
            'longitude' =>  $request->longitude,
            'created_by' => auth('teacher')->id(),
            'school_id' => auth('teacher')->user()->school_id,
        ];
        User::create($data);
        return redirect()->back()->with('success', 'Parent Added Successfully');
    }

    public function childForm($parent_id)
    {
        $drivers = DB::table('drivers')
                    ->select(
                        'id',
                        'name'
                    )
                    ->get();
        // return $drivers;
        return view('Teacher.parents.create-student', compact('parent_id','drivers'));
    }

    public function addChild(AddStudentRequest $request) 
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => "student",
            'latitude' =>  $request->latitude,
            'longitude' =>  $request->longitude,
            'created_by' => auth('teacher')->id(),
            'school_id' => auth('teacher')->user()->school_id,
            'parent_id' => (int) $request->parent_id,
            'driver_id' => (int) $request->driver_id,
        ];
        User::create($data);
        return redirect()->back()->with('success', 'Child Added Successfully');
        
    }

    public function deleteParent($parent_id)
    {
        DB::table('users')->where('id', $parent_id)->orWhere('parent_id', $parent_id)->delete();
        return redirect()->route('teacher-admin-parents')->with('success', 'Parent Deleted Successfully');
    }
}
