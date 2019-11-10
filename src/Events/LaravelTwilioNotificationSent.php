<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Models\LaravelTwilioMessage;

class LaravelTwilioNotificationSent
{
    use Dispatchable, SerializesModels;

    /**
     * @var LaravelTwilioMessage
     */
    public $message;
    /**
     * @var
     */
    public $notifiable;

    /**
     * TwilioNotificationSuccess constructor.
     *
     * @param  LaravelTwilioMessage  $message
     * @param $notifiable
     */
    public function __construct(LaravelTwilioMessage $message, $notifiable)
    {
        $this->message = $message;
        $this->notifiable = $notifiable;
    }
}
