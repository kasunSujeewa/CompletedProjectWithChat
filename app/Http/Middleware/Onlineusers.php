<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;


use Illuminate\Support\Facades\Auth;



class Onlineusers
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
        if (Auth::check()) {
            $expireAt = Carbon::now()->addMinutes(2);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expireAt);
        }
        return $next($request);
    }
}
