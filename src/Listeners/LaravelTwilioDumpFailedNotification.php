<?php

namespace Rocky\LaravelTwilio\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Rocky\LaravelTwilio\Events\LaravelTwilioNotificationFailed;

class LaravelTwilioDumpFailedNotification
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
     * @param  LaravelTwilioNotificationFailed  $event
     *
     * @return void
     */
    public function handle(LaravelTwilioNotificationFailed $event)
    {
        if (app()->runningInConsole() && app()->environment() === 'development') {
            print_r($event->exception->getMessage());
        }
    }
}
