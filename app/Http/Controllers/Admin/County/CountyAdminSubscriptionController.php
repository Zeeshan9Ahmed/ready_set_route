<?php

namespace App\Http\Controllers\Admin\County;

use App\Models\Plan;
use App\Models\PurchasePlan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe;
class CountyAdminSubscriptionController extends Controller
{
    public function subscription()
    {
        $plans = Plan::with('features')->where('is_deleted', false)->get();
        
        // return $plans;

        $plan_is_purchased = PurchasePlan::where('user_id', auth('admin')->id())->orderByDesc('id')->first();
        
        if(!$plan_is_purchased)
        {
            $message = "";
            return view('County.subscription.index', compact('plans', 'message'));


           
        }
        elseif(( $plan_is_purchased->end_date < Carbon::today()  ))
        {
            $message = "Subscription Has been Expired";
            return view('County.subscription.index', compact('plans', 'message'));
            
        }else{

            return redirect('sub-admin-county/dashboard');

        }
        
    }
    
    public function plan_post(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);

        $end_date = '';
        $date = Carbon::now();
        if ($plan->type == 'monthly') {
            $end_date = $date->addMonth();
        }else{
            $end_date = $date->addYear();
        }
        $price = $plan->price;
        $is_discounted_price = '0';
        
        if($plan->off > 0){
            $price = $plan->off;
            $is_discounted_price = '1';
        }
        
        try {
            
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $stripe = Stripe\Charge::create ([
                "amount" => $price * 100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => auth('admin')->user()->name . " purchase plan " . $plan->title . "."
            ]);
            
            $purchasePlan = new PurchasePlan;
            $purchasePlan->user_id = auth('admin')->user()->id;
            $purchasePlan->user_type = 'county';
            $purchasePlan->plan_id = $request->plan_id;
            $purchasePlan->price = $price;
            $purchasePlan->is_discounted_price = $is_discounted_price;
            $purchasePlan->stripe_token  = $request->stripeToken;
            $purchasePlan->stripe_id  = $stripe->id;
            $purchasePlan->stripe_status  = $stripe->status;
            $purchasePlan->stripe_price  = $stripe->amount;
            $purchasePlan->currency  = $stripe->currency;
            $purchasePlan->quantity  = 1;
            $purchasePlan->start_date  = date('Y-m-d');
            $purchasePlan->end_date  = $end_date;
            $purchasePlan->receipt_url  = $stripe->receipt_url;
            $purchasePlan->is_expire  = '0';
            $purchasePlan->save();
            
            return back()->with('success','Subscription is completed.');
            
        }
        catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }
        
        return $stripe;
    }
}
