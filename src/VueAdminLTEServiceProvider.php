<?php

namespace LaravelEnso\VueAdminLte;

use Illuminate\Support\ServiceProvider;

class VueAdminLTEServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js/vendor/laravel-enso'),
        ], 'vue-adminlte');

        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js/vendor/laravel-enso'),
        ], 'enso-update');
    }

    public function register()
    {
        //
    }
}
