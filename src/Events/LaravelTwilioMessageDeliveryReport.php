<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\MessageDeliveryReport;

class LaravelTwilioMessageDeliveryReport
{
    use Dispatchable, SerializesModels;
    /**
     * @var MessageDeliveryReport
     */
    private $report;

    /**
     * TwilioNotificationSuccess constructor.
     *
     * @param  MessageDeliveryReport  $report
     */
    public function __construct(MessageDeliveryReport $report)
    {
        $this->report = $report;
    }

    /**
     * @return MessageDeliveryReport
     */
    public function getReport(): MessageDeliveryReport
    {
        return $this->report;
    }

}
