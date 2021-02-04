<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next)
    {

        if (Auth::user()->role === 2) {
            return $next($request);
        }
        else {
            return response()->json([
                'status' => "Error",
                'msg' => 'Unauthorized'
            ], 403);
        }
    }
}
