<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force HTTPS when running behind reverse proxy or tunnel (like Cloudflare or Localtunnel)
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        } elseif (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            URL::forceScheme('https');
        } elseif (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        } else {
            // Also force HTTPS if accessed via trycloudflare or loca.lt
            $host = request()->getHost();
            if (str_contains($host, 'trycloudflare.com') || str_contains($host, 'loca.lt')) {
                URL::forceScheme('https');
            }
        }
    }
}
