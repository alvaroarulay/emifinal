<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAjaxRequest
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        return $next($request);
    }
}
