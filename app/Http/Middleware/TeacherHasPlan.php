<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CheckSubscriptionController;
use Closure;
use Illuminate\Http\Request;

class TeacherHasPlan
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
        
        if($subscription->checkSubscription($subscription->getCountyIdOfSchool($subscription->getCountyIdOfTeacher(auth('teacher')->user()->school_id))) == false)
        {
            return redirect()->route('teacher-page');
        };

        return $next($request);
        
    }
}
