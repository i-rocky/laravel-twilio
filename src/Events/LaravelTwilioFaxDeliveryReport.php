<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\FaxDeliveryReport;

class LaravelTwilioFaxDeliveryReport
{
    use Dispatchable, SerializesModels;
    /**
     * @var FaxDeliveryReport
     */
    private $report;

    /**
     * TwilioNotificationSuccess constructor.
     *
     * @param  FaxDeliveryReport  $report
     */
    public function __construct(FaxDeliveryReport $report)
    {
        $this->report = $report;
    }

    /**
     * @return FaxDeliveryReport
     */
    public function getReport(): FaxDeliveryReport
    {
        return $this->report;
    }

}
