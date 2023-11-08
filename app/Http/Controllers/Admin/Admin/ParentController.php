<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function parents()
    {
        
        
            $parents = DB::table('users')
                            ->join('users as child', 'child.parent_id', 'users.id')
                            ->join('teachers', 'teachers.id', 'users.created_by')
                            ->select(
                                'users.id as parent_id',
                                'users.name as parent_name',
                                'users.email',
                                'teachers.name as teacher_name',
                                DB::raw('(select group_concat(id) from users as upt where FIND_IN_SET(upt.parent_id,users.id) AND upt.role = "student") as studentIds'), 
                                DB::raw('(select group_concat(driver_id) from users as upt where FIND_IN_SET(upt.parent_id,users.id) AND upt.role = "student") as driverIds'), 
                                DB::raw('(select count(id) from users as us where FIND_IN_SET(us.id,studentIds) AND us.role = "student") as student_count'),
                                DB::raw('(select count(id) from drivers where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),

                            )
                            ->where('users.role', 'parent')
                            ->groupBy('users.id')
                            ->get();
            // return $parents;
        return view('Admin.parents.index', compact('parents'));
    }

    public function parentDetail($parent_id)
    {
        $childrens = User::
                        join('teachers','teachers.id', 'users.created_by')
                        ->join('drivers', 'drivers.id', 'users.driver_id')
                        ->join('schools', 'schools.id', 'users.school_id')
                        ->join('counties', 'counties.id', 'schools.county_id')
                        ->select(
                            'users.id',
                            'users.name as student_name',
                            'users.email',
                            'schools.school_name',
                            'drivers.name as driver_name',
                            'teachers.name as teacher_name',
                            'counties.county_name'
                        )
                        ->where('parent_id', $parent_id)
                        ->get();
        return view('Admin.parents.parent-detail', compact('childrens'));
        
    }
}
