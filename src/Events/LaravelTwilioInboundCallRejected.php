<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\InboundCall;

class LaravelTwilioInboundCallRejected
{
    use Dispatchable, SerializesModels;
    /**
     * @var InboundCall
     */
    private $call;

    /**
     * LaravelTwilioInboundCall constructor.
     *
     * @param  InboundCall  $call
     */
    public function __construct(InboundCall $call)
    {

        $this->call = $call;
    }

    /**
     * @return InboundCall
     */
    public function getCall(): InboundCall
    {
        return $this->call;
    }
}
