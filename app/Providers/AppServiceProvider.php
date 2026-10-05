<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.*', 'site.*', 'partials.*', 'admin.*'], function ($view) {
            try {
                $view->with('site', Setting::map());
            } catch (\Throwable $e) {
                $view->with('site', []);
            }
        });

        View::composer('layouts.site', function ($view) {
            try {
                $view->with('footerServices', Service::active()->take(6)->get());
            } catch (\Throwable $e) {
                $view->with('footerServices', collect());
            }
        });

        View::composer('layouts.admin', function ($view) {
            try {
                $view->with('badges', [
                    'quotes' => QuoteRequest::where('status', 'new')->count(),
                    'messages' => ContactMessage::where('is_read', false)->count(),
                ]);
            } catch (\Throwable $e) {
                $view->with('badges', ['quotes' => 0, 'messages' => 0]);
            }
        });

                Schema::defaultStringLength(191);

    }
}
