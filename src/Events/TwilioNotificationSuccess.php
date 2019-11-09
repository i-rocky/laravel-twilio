<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Queue\SerializesModels;
use Twilio\InstanceResource;

class TwilioNotificationSuccess
{
    use SerializesModels;

    /**
     * @var InstanceResource
     */
    public $message;

    public function __construct(InstanceResource $message)
    {
        $this->message = $message;
    }
}
