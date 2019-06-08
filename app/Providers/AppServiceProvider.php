<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('components.button', 'button');
        Blade::component('components.form', 'form');
        Blade::component('components.input', 'input');
        Blade::component('components.link', 'link');
        Blade::component('components.map', 'map');
        Blade::component('components.select', 'select');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
