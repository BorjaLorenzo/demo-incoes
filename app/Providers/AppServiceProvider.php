<?php

namespace App\Providers;

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
    //Descomentar esta funcion cuando se suba una copia del proyecto entera
    // public function register()
    // {
    //     $this->app->bind('path.public',function(){
    //         return'/usr/home/sosmanager.xyz/web';
    //         });
    // }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
