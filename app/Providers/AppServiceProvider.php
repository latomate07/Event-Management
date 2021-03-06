<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'errors' => function () {
                return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : (object) [];},
        ]);
  
        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
            ];
        });
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
         }
    }
}
