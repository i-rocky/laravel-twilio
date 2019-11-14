<?php

namespace Rocky\LaravelTwilio\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSendingFailed;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSent;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioDumpFailedNotification;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioDumpNotification;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole() && $this->app->environment() === 'local') {
            $this->listen = [
                LaravelTwilioMessageSent::class          => [
                    LaravelTwilioDumpNotification::class,
                ],
                LaravelTwilioMessageSendingFailed::class => [
                    LaravelTwilioDumpFailedNotification::class,
                ]
            ];
        }
    }
}
