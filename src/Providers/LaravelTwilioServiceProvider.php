<?php

namespace Rocky\LaravelTwilio\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Rocky\LaravelTwilio\Console\Commands\InstallLaravelTwilio;
use Rocky\LaravelTwilio\Http\Middleware\VerifyTwilioRequest;
use Rocky\LaravelTwilio\LaravelTwilio;
use Rocky\LaravelTwilio\Services\TwilioService;
use Rocky\LaravelTwilio\TwilioChannel;
use Rocky\LaravelTwilio\TwilioConfig;

class LaravelTwilioServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Provides configuration
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->_publishConfig();
            $this->_publishAssets();
            $this->_registerCommands();
        }

        $this->_setupServiceContainer();
    }

    /**
     * Does something
     *
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->_loadConfig();
        $this->_registerConfigProvider();

        $this->app->register(RouteServiceProvider::class);

        if ($this->app->environment() === 'local') {
            $this->app->register(EventServiceProvider::class);
        }

        $this->app->make('router')->aliasMiddleware('verify-twilio-request', VerifyTwilioRequest::class);
    }

    /**
     * Setup service container to serve dependency injection
     */
    private function _setupServiceContainer()
    {
        $this->app->when(TwilioChannel::class)
                  ->needs(LaravelTwilio::class)
                  ->give(function () {
                      return new LaravelTwilio(
                          $this->app->make(TwilioService::class),
                          $this->app->make(TwilioConfig::class)
                      );
                  });
        $this->app->bind(TwilioService::class, function () {
            $config      = $this->app['config']['services.twilio'];
            $account_sid = Arr::get($config, 'account_sid');
            $username    = Arr::get($config, 'username');
            if ( ! empty($username)) {
                $password = Arr::get($config, 'password');

                return new TwilioService($username, $password, $account_sid);
            } else {
                $auth_token = Arr::get($config, 'auth_token');

                return new TwilioService($account_sid, $auth_token);
            }
        });
    }

    /**
     *
     */
    private function _registerConfigProvider()
    {
        $this->app->bind(TwilioConfig::class, function () {
            return new TwilioConfig($this->app['config']['services.twilio']);
        });
    }

    /**
     *
     */
    private function _loadConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-twilio');
    }

    /**
     *
     */
    private function _publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-twilio.php'),
        ], 'config');
    }

    /**
     *
     */
    private function _publishAssets()
    {
        $this->publishes([
            __DIR__.'/../resources/assets/js'   => resource_path('assets/js/vendor/laravel-twilio'),
        ], 'assets');
    }

    /**
     *
     */
    private function _registerCommands()
    {
        $this->commands([
            InstallLaravelTwilio::class,
        ]);
    }
}