<?php

namespace Rocky\LaravelTwilio\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Rocky\LaravelTwilio\Events\LaravelTwilioNotificationFailed;
use Rocky\LaravelTwilio\Events\LaravelTwilioNotificationSent;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioDumpFailedNotification;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioDumpNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LaravelTwilioNotificationSent::class   => [
            LaravelTwilioDumpNotification::class,
        ],
        LaravelTwilioNotificationFailed::class => [
            LaravelTwilioDumpFailedNotification::class,
        ]
    ];
}
