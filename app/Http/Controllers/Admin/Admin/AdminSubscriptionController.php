<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSubscriptionController extends Controller
{
    public function subscription()
    {

        $plans = Plan::with('features')->where('is_deleted', false)->get();
        
        return view('Admin.subscriptions.index', compact('plans'));
    }

    public function package()
    {
        return view('Admin.subscriptions.add-package');
    }

    public function deletePackage($package_id)
    {
        $plan = Plan::findOrFail($package_id);
        $plan->is_deleted = true;
        $plan->save();
        return redirect()->back()->with('success',"Package Deleted Successfully");
    }
    public function editPackage($package_id)
    {
        $plan = Plan::with('features')->where('id', $package_id)->first();
        // return $plan;
        return view('Admin.subscriptions.edit-package', compact('plan'));
    }

    public function deletePackageFeature(Request $request)
    {
        if (PlanFeature::whereId($request->feature_id)->delete())
        {
            return array('status' => 1, 'message' => 'Ok.');
        }
        return array('status' => 0, 'message' => 'Something Went Wrong.');
    }

    public function editPackageDetail(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $plan->title = $request->title ;
        $plan->description = $request->description ;
        $plan->price = $request->price ;
        $plan->off = $request->off ;
        $plan->type = $request->type ;
        $plan->save();
        
        foreach($request->feature?$request->feature:[] as $key => $feature)
        {
            if(array_key_exists($key, $request->feature_id))
            {
                PlanFeature::where('id',$request->feature_id[$key])->update([
                    'feature' => $feature,
                ]);
                
            }else{
                PlanFeature::create([
                    'plan_id' => $plan->id,
                    'feature' => $feature
                ]);
                
            }
        }
        return redirect()->back()->with('success',"Package Updated Successfully");
    }

    public function savePackage(Request $request)
    {
        $plan = Plan::create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'off' => $request->off,
                'type' => $request->type,
            ]
        );

        foreach ($request->feature as $feature)
        {
            $feature = [
                'plan_id' => $plan->id,
                'feature' => $feature ,
            ];

            PlanFeature::create($feature);
        }
        return redirect()->back();
    }

    public function subscriptionHistory()
    {
        //county name , package , price, status,subscribe ,expires, 
        $purchased_plans = DB::table('purchase_plans')
                        ->leftjoin('admins','admins.id', 'purchase_plans.user_id')
                        ->leftjoin('counties','counties.id','admins.county_id')
                        ->leftjoin('plans','plans.id','purchase_plans.plan_id')
                        ->select(
                            'purchase_plans.id',
                            'admins.name as user_name',
                            'counties.county_name',
                            'plans.title',
                            'plans.price',
                            'purchase_plans.end_date',
                            'purchase_plans.created_at',
                        )
                        ->orderByDesc('purchase_plans.id')
                        ->get();
        return view('Admin.subscriptions.subscription-history', compact('purchased_plans'));
    }
}
