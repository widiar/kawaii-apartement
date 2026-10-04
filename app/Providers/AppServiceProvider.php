<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
        UrlGenerator::macro('setLanguage', function ($language) {
            $currentRoute = app('router')->current();
            $newRouteParameters = array_merge(
                $currentRoute->parameters(),
                compact('language')
            );
            return $this->route($currentRoute->getName(), $newRouteParameters);
        });
    }
}
