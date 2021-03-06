<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

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
        Schema::defaultStringLength(191);

        Blade::if('active', function () {            
            if (auth()->user() && auth()->user()->active) {
                return 1;
            }
            return 0;
        });

        Blade::if('admin', function () {            
            if (auth()->user() && auth()->user()->admin) {
                return 1;
            }
            return 0;
        });
    }
}
