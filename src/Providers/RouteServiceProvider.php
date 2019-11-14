<?php

namespace Rocky\LaravelTwilio\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Rocky\LaravelTwilio\Http\Controllers';

    /**
     * Map the routes for Laravel Twilio
     */
    public function map()
    {
        $this->_mapWebRoutes();

        $this->_mapApiRoutes();
    }

    /**
     *
     */
    private function _mapWebRoutes()
    {
        Route::prefix(config('laravel-twilio.base_url', 'laravel-twilio'))
             ->middleware('web')
             ->namespace($this->namespace)
             ->group(__DIR__.'/../routes/web.php');
    }

    /**
     *
     */
    private function _mapApiRoutes()
    {
        Route::prefix('api/'.config('laravel-twilio.base_url', 'laravel-twilio'))
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(__DIR__.'/../routes/api.php');
    }
}
