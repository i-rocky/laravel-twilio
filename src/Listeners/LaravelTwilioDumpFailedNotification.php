<?php

namespace Rocky\LaravelTwilio\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSendingFailed;

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
     * @param  LaravelTwilioMessageSendingFailed  $event
     *
     * @return void
     */
    public function handle(LaravelTwilioMessageSendingFailed $event)
    {
        if (app()->runningInConsole() && app()->environment() === 'local') {
            dd($event->exception);
        }
    }
}
