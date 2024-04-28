<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        if(env('REDIRECT_HTTPS'))
        {
            $url->forceSchema('https');
        }
//        if(env('APP_ENV') === 'production') {
//            URL::forceScheme('https');
//        }



    }
}
