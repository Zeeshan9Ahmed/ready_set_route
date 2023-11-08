<?php

namespace App\Http\Controllers;

use App\Models\PurchasePlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckSubscriptionController extends Controller
{
    public function checkSubscription($county_id)
    {
        $plan_is_purchased = PurchasePlan::where('user_id', $county_id)->orderByDesc('id')->first();
        
        if(!$plan_is_purchased)
        {
            return false;
        }
        elseif(( $plan_is_purchased->end_date < Carbon::today()  ))
        {
            return false;
        }

        return true;
    }

    public function getCountyIdOfSchool($county_id)
    {
        return DB::table('admins')->where('county_id', $county_id)->first()?->id;
    }

    public function getCountyIdOfTeacher($school_id)
    {
        return DB::table('schools')->whereId($school_id)->first()?->county_id;
    }
    

}
