<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

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
        UrlGenerator::macro('setLanguage', function($language){
            $currentRoute = app('router')->current();
            $newRouteParameters = array_merge(
                $currentRoute->parameters(), compact('language')
            );
            return $this->route($currentRoute->getName(), $newRouteParameters);
        });
    }
}
