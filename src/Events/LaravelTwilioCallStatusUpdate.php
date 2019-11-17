<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\CallStatus;
use Rocky\LaravelTwilio\Contracts\InboundCall;

class LaravelTwilioCallStatusUpdate
{
    use Dispatchable, SerializesModels;
    /**
     * @var CallStatus
     */
    private $status;

    /**
     * LaravelTwilioCallStatus constructor.
     *
     * @param  CallStatus  $status
     */
    public function __construct(CallStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return CallStatus
     */
    public function getStatus(): CallStatus
    {
        return $this->status;
    }
}
