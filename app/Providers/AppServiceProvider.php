<?php

namespace App\Providers;

use App\Contracts\StayBookingProvider;
use App\Services\Booking\EnquiryBookingProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Swap this binding for a booking-engine provider to switch Stays to instant booking.
        $this->app->bind(StayBookingProvider::class, EnquiryBookingProvider::class);
    }

    public function boot(): void
    {
        RateLimiter::for('enquiries', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
    }
}
