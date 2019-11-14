<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\IncomingMessage;

class LaravelTwilioIncomingMessage
{
    use Dispatchable, SerializesModels;

    /**
     * @var IncomingMessage
     */
    public $message;

    /**
     * @return IncomingMessage
     */
    public function getMessage(): IncomingMessage
    {
        return $this->message;
    }

    /**
     * TwilioNotificationSuccess constructor.
     *
     * @param  IncomingMessage  $message
     */
    public function __construct(IncomingMessage $message)
    {
        $this->message = $message;
    }
}
