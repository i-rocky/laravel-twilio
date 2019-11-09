<?php

namespace Rocky\LaravelTwilio\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Rocky\LaravelTwilio\LaravelTwilio;
use Rocky\LaravelTwilio\TwilioChannel;
use Rocky\LaravelTwilio\TwilioConfig;
use Rocky\LaravelTwilio\TwilioService;

class TwilioServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Provides configuration
     */
    public function boot()
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
     * Does something
     */
    public function register()
    {
        $this->app->bind(TwilioConfig::class, function () {
            return new TwilioConfig($this->app['config']['services.twilio']);
        });
    }
}