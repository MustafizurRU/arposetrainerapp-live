<?php

namespace App\Providers;


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        if(env('APP_ENV') === 'production') {
            $url = Request::url();
            $check = strstr($url, 'https://');
            if($check){
                $newUrl = str_replace('https://', 'http://', $url);
                header("Location: $newUrl");
            }
        }
//        if(env('APP_ENV') === 'production') {
//            URL::forceScheme('https');
//        }



    }
}
