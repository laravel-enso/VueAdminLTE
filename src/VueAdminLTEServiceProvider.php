<?php

namespace LaravelEnso\VueAdminLTE;

use Illuminate\Support\ServiceProvider;

class VueAdminLTEServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js/vendor/laravel-enso'),
        ], 'vue-components');
    }

    public function register()
    {
        //
    }
}
