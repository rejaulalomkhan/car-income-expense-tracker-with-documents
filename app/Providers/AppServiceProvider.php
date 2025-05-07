<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NotificationService;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Layouts\App;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NotificationService::class);
    }

    public function boot(): void
    {
        // Share theme settings with all views
        View::composer('*', function ($view) {
            $theme = Setting::where('key', 'theme')->first()?->value ?? 'light';
            $logo = Setting::where('key', 'logo')->first()?->value;
            $icon = Setting::where('key', 'icon')->first()?->value;
            $view->with('theme', $theme);
            $view->with('appLogo', $logo);
            $view->with('appIcon', $icon);
        });

        Blade::component('app-layout', App::class);
    }
}
