<?php

namespace Rocky\LaravelTwilio\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Rocky\LaravelTwilio\Events\LaravelTwilioNotificationSent;

class LaravelTwilioDumpNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LaravelTwilioNotificationSent  $event
     *
     * @return void
     */
    public function handle(LaravelTwilioNotificationSent $event)
    {
        if (app()->runningInConsole() && app()->environment() === 'development') {
            print_r($event->message->toArray());
        }
    }
}
