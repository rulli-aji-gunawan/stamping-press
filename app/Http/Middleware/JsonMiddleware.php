<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isJson()) {
            return $next($request);
        }

        return response()->json(['error' => 'Only JSON requests are allowed'], 415);
    }
}
