<?php

namespace Rocky\LaravelTwilio\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Rocky\LaravelTwilio\Events\LaravelTwilioCallStatusUpdate;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSendingFailed;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSent;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioCallStatusLogger;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioDumpFailedNotification;
use Rocky\LaravelTwilio\Listeners\LaravelTwilioDumpNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LaravelTwilioMessageSent::class          => [
            LaravelTwilioDumpNotification::class,
        ],
        LaravelTwilioMessageSendingFailed::class => [
            LaravelTwilioDumpFailedNotification::class,
        ],
        LaravelTwilioCallStatusUpdate::class     => [
            LaravelTwilioCallStatusLogger::class,
        ]
    ];
}
