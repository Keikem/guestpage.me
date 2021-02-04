<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsAdminOrSelf
{

    public function handle(Request $request, Closure $next)
    {
        $requestedUserId = $request->route()->parameter('id');

        if (
            Auth::user()->role === 2 ||
            Auth::user()->id == $requestedUserId
        ) {
            return $next($request);
        }
        else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unauthorized'
            ], 403);
        }
        
    }
}
