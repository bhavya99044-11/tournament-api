<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiResponse;
class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($user=auth('api')->user()){
            return $next($request);
        }
        return ApiResponse::error('unauthorized',401);
    }
}
