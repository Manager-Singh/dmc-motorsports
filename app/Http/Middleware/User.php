<?php

namespace App\Http\Middleware;

use Closure;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->role=='user'){
            if(empty(session('user'))){
                return redirect()->route('login.form');
            }
            else{
                return $next($request);
            }
        }else{
            if($request->user()->role=='admin'){
            request()->session()->flash('error','You are admin not make checkout!');
            return redirect()->route($request->user()->role);
            }
            request()->session()->flash('error','Login/ Register first!');
            return redirect()->route('login.form');
        }
    }
}
