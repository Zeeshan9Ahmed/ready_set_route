<?php

namespace App\Http\Middleware;
use App\Models\PurchasePlan;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class PlanIsPurchase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $plan_is_purchased = PurchasePlan::where('user_id', auth('admin')->id())->orderByDesc('id')->first();
        
        if(!$plan_is_purchased)
        {
            return redirect('sub-admin-county/subscription');
        }
        elseif(( $plan_is_purchased->end_date < Carbon::today()  ))
        {
            return redirect('sub-admin-county/subscription');
        }else{

            return $next($request);
        }
       
    }
}
