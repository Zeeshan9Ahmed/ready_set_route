<?php

namespace App\Http\Controllers\Admin\County;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function getParents()
    {
        $school_ids = School::where('invited_by', auth('admin')->id())->pluck('id');
        
        $parent_ids = User::whereIn('school_id', $school_ids)->pluck('parent_id');
        $parents = User::
                        join('teachers', 'teachers.id', 'users.created_by')
                        ->join('schools', 'schools.id', 'teachers.school_id')
                        ->select(
                            'users.id',
                            'users.name as parent_name',
                            'users.email',
                            'teachers.name as teacher_name',
                            'schools.school_name',
                            'schools.id as school_id',
                            DB::raw('(select count(id) from users as us where FIND_IN_SET(us.school_id,schools.id) AND us.role = "student") as student_count'), 
                            DB::raw('(select group_concat(driver_id) from school_drivers where school_drivers.school_id = schools.id) as driverIds'),
                            DB::raw('(select count(id) from drivers  where FIND_IN_SET(drivers.id,driverIds)) as driver_count'),
                        )
                        ->whereIn('users.id',$parent_ids)->get();
        // return $parent_ids;
        // return $parents;
        
        return view('County.parents.index', compact('parents'));
    }

    public function parentDetail($parent_id)
    {
        $children = DB::table('users')
                        ->join('teachers', 'teachers.id', 'users.created_by')
                        ->join('schools', 'schools.id', 'users.school_id')
                        ->join('drivers', 'drivers.id', 'users.driver_id')
                        ->select(
                            'users.id',
                            'users.name as child_name',
                            'users.email',
                            'drivers.name as driver_name',
                            'schools.school_name',
                            'teachers.name as teacher_name'
                        )
                        ->where('users.parent_id', $parent_id)
                        ->get();
        // return $children;
        return view('County.parents.parent-detail', compact('children'));   
        dd($parent_id);
    }
}
