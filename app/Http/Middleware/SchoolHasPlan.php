<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CheckSubscriptionController;
use Closure;
use Illuminate\Http\Request;

class SchoolHasPlan
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
          $subscription = new CheckSubscriptionController();
        
        if($subscription->checkSubscription($subscription->getCountyIdOfSchool(auth('school')->user()->county_id)) == false)
        {
            // dd('d');
            return redirect()->route('school-page');
        };

        return $next($request);
    }
}
