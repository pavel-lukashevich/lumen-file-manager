<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
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
        if (App::environment() !== 'production') {
            App::register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            App::register(\Thedevsaddam\LumenRouteList\LumenRouteListServiceProvider::class);
        }
    }
}
