<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;


class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
         if (Auth::user()->role=='admin') {
            return $next($request);
         }else{
            return "You Don't Have Permission";
         }
      }
   
        return redirect('login')->with('error','Login First');
    }
}