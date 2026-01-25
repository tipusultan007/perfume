<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\MergeCartOnLogin::class
        );

        Paginator::useTailwind();

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $activePopup = \App\Models\Popup::where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                })
                ->orderBy('created_at', 'desc')
                ->first();

            $view->with('activePopup', $activePopup);
        });
    }
}
