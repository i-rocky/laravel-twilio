<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Twilio\InstanceResource;

class LaravelTwilioMessageSent
{
    use Dispatchable, SerializesModels;

    /**
     * @var InstanceResource
     */
    private $message;
    /**
     * @var
     */
    private $notifiable;

    /**
     * TwilioNotificationSuccess constructor.
     *
     * @param  InstanceResource  $message
     * @param $notifiable
     */
    public function __construct(InstanceResource $message, $notifiable)
    {
        $this->message    = $message;
        $this->notifiable = $notifiable;
    }

    /**
     * @return InstanceResource
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getNotifiable()
    {
        return $this->notifiable;
    }
}
