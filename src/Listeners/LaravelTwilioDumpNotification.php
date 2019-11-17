<?php

namespace Rocky\LaravelTwilio\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSent;

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
     * @param  LaravelTwilioMessageSent  $event
     *
     * @return void
     */
    public function handle(LaravelTwilioMessageSent $event)
    {
        if (app()->runningInConsole() && app()->environment() === 'local') {
            dd($event->getMessage());
        }
    }
}
