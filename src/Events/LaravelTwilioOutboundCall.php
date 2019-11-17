<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\OutboundCall;

/**
 * Class LaravelTwilioOutboundCall
 *
 * @package Rocky\LaravelTwilio\Events
 */
class LaravelTwilioOutboundCall
{
    use Dispatchable, SerializesModels;
    /**
     * @var OutboundCall
     */
    private $call;

    /**
     * LaravelTwilioOutboundCall constructor.
     *
     * @param  OutboundCall  $call
     */
    public function __construct(OutboundCall $call)
    {
        $this->call = $call;
    }

    /**
     * @return OutboundCall
     */
    public function getCall(): OutboundCall
    {
        return $this->call;
    }
}
