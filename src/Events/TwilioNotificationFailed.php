<?php

namespace Rocky\LaravelTwilio\Events;

use Exception;
use Illuminate\Queue\SerializesModels;

class TwilioNotificationFailed
{
    use SerializesModels;

    /**
     * @var Exception
     */
    public $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }
}
