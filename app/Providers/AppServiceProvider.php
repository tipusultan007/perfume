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

        // Dynamic Mail Configuration
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailConfig = [
                    'driver' => \App\Models\Setting::get('mail_mailer', config('mail.default')),
                    'host' => \App\Models\Setting::get('mail_host', config('mail.mailers.smtp.host')),
                    'port' => \App\Models\Setting::get('mail_port', config('mail.mailers.smtp.port')),
                    'from' => [
                        'address' => \App\Models\Setting::get('mail_from_address', config('mail.from.address')),
                        'name' => \App\Models\Setting::get('mail_from_name', config('mail.from.name')),
                    ],
                    'encryption' => \App\Models\Setting::get('mail_encryption', config('mail.mailers.smtp.encryption')),
                    'username' => \App\Models\Setting::get('mail_username', config('mail.mailers.smtp.username')),
                    'password' => \App\Models\Setting::get('mail_password', config('mail.mailers.smtp.password')),
                ];

                config(['mail.default' => $mailConfig['driver']]);
                config(['mail.mailers.smtp.host' => $mailConfig['host']]);
                config(['mail.mailers.smtp.port' => $mailConfig['port']]);
                config(['mail.mailers.smtp.encryption' => $mailConfig['encryption']]);
                config(['mail.mailers.smtp.username' => $mailConfig['username']]);
                config(['mail.mailers.smtp.password' => $mailConfig['password']]);
                config(['mail.from.address' => $mailConfig['from']['address']]);
                config(['mail.from.name' => $mailConfig['from']['name']]);
            }
        } catch (\Exception $e) {
            // Avoid failing if DB is not ready
        }

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
