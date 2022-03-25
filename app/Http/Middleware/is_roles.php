<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class is_roles
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
        if(auth()->user()){
            if(auth()->user()->roles==1){
                return $next($request);
            } 
        } 
        return back()->with("error", "สิทธิ์การเข้าใช้งานระบบผิดผลาด !"); 
    }
}
