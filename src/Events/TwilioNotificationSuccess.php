<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\SerializesModels;
use Twilio\InstanceResource;

class TwilioNotificationSuccess
{
    use SerializesModels;

    /**
     * @var InstanceResource
     */
    public $message;
    /**
     * @var
     */
    public $notifiable;

    /**
     * TwilioNotificationSuccess constructor.
     *
     * @param  InstanceResource  $message
     * @param $notifiable
     */
    public function __construct(InstanceResource $message, $notifiable)
    {
        $this->message = $message;
        $this->notifiable = $notifiable;
    }
}
