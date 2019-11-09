<?php

namespace Rocky\LaravelTwilio;

use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notification;
use Rocky\LaravelTwilio\Events\TwilioNotificationFailed;
use Rocky\LaravelTwilio\Events\TwilioNotificationSuccess;
use Rocky\LaravelTwilio\Foundation\TwilioMessage;

class TwilioChannel
{
    /**
     * @var LaravelTwilio
     */
    private $laravelTwilio;
    /**
     * @var Dispatcher
     */
    private $events;

    /**
     * TwilioChannel constructor.
     *
     * @param  LaravelTwilio  $laravelTwilio
     * @param  Dispatcher  $events
     */
    public function __construct(LaravelTwilio $laravelTwilio, Dispatcher $events)
    {

        $this->laravelTwilio = $laravelTwilio;
        $this->events        = $events;
    }

    /**
     * @param $notifiable
     * @param  Notification  $notification
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            /** @var TwilioMessage $message */
            $message = $notification->toTwilio($notification);

            $instance = $message->send($notifiable, $this->laravelTwilio);

            $event = new TwilioNotificationSuccess($instance);
            $this->_dispatchEvent($event);
        } catch (Exception $exception) {
            // no point retrying
            $event = new TwilioNotificationFailed($exception);
            $this->_dispatchEvent($event);
        }
    }

    private function _dispatchEvent($event)
    {
        if (function_exists('event')) {
            event($event);
        } else {
            $this->events->dispatch($event);
        }
    }
}
