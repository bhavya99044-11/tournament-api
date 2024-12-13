<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RouteLimiter;
use Illuminate\Http\Request;


class RateLimitProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      RateLimiter::for('api_login',function(Request $request){
        return Limit::perMinute(5)->by(optional(auth('api')->user())->id?:$request->ip());
      });
    }
}
