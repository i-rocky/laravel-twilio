<?php

namespace Rocky\LaravelTwilio\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Rocky\LaravelTwilio\Events\LaravelTwilioCallStatusUpdate;
use Rocky\LaravelTwilio\Events\LaravelTwilioMessageSent;

class LaravelTwilioCallStatusLogger
{

    /**
     * Handle the event.
     *
     * @param  LaravelTwilioCallStatusUpdate  $event
     *
     * @return void
     */
    public function handle(LaravelTwilioCallStatusUpdate $event)
    {
        if (app()->environment() === 'local') {
            \Log::info("Call Status: ".$event->getStatus()->CallStatus);
        }
    }
}
