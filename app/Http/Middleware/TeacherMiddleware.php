<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->tokenCan('role:teacher')) {
            return $next($request);
        }

        return response()->json('Not Authorized', 401);;
    }
}