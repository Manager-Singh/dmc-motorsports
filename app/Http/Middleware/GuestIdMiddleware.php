<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class GuestIdMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the guest_id is not set in the session
        if (!$request->session()->has('guest_id')) {
            // Generate a new UUID and store it in the session
            $request->session()->put('guest_id', Str::uuid()->toString());
        }

        // Continue processing the request
        return $next($request);
    }
}