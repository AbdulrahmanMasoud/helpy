<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLang
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
        // app()->setLocale($request->header('language') ?? 'ar');
        if ($request->language == 'ar') {
            app()->setLocale('ar');
        }
        
        return $next($request);
    }
}
