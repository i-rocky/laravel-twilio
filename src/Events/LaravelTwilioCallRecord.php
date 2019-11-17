<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\CallRecord;

class LaravelTwilioCallRecord
{
    use Dispatchable, SerializesModels;
    /**
     * @var CallRecord
     */
    private $record;

    /**
     * LaravelTwilioInboundCall constructor.
     *
     * @param  CallRecord  $record
     */
    public function __construct(CallRecord $record)
    {

        $this->record = $record;
    }

    /**
     * @return CallRecord
     */
    public function getRecord(): CallRecord
    {
        return $this->record;
    }
}
