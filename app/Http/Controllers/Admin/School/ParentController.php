<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function getParents()
    {

        $parents = User::
                        join('users as parents', 'parents.id', 'users.parent_id')
                        ->leftjoin('teachers', 'teachers.id', 'parents.created_by')
                        ->select(
                            'parents.id',
                            'parents.name as parent_name',
                            'parents.email',
                            'teachers.name as teacher_name',
                            DB::raw('( select group_concat(id) from users where users.parent_id = parents.id AND users.role = "student" ) as childrenIds'),
                            DB::raw('(select count(id) from users as childs where FIND_IN_SET (childs.id, childrenIds) ) as children_count'),
                            DB::raw('( select group_concat(driver_id) from users  where users.parent_id = parents.id AND users.role = "student" ) as driverIds'),
                            DB::raw('(select count(id) from drivers where FIND_IN_SET (drivers.id, driverIds) ) as driver_count'),
                        )
                        ->where('users.school_id', auth('school')->id())
                        ->groupBy('id')
                        ->get();
        // return $parents;
        // return 'tea';
        return view('School.parents.index', compact('parents'));

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
                            'users.email',
                            'teachers.name as teacher_name',
                            'drivers.name as driver_name',
                            'school_name'
                        )
                        ->where('users.parent_id', $parent_id)
                        ->get();
        // return $children;
        return view('School.parents.parent-detail', compact('children'));
        
    }
}
