<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('orders', fn (Request $request) => Limit::perHour(10)->by($request->ip()));

        View::composer('layouts.shop', function ($view) {
            $count = 0;
            foreach ((array) session('cart', []) as $line) {
                $count += max(0, (int) ($line['quantity'] ?? 0));
            }
            $view->with('cartItemCount', $count);
        });
    }
}
