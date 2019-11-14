<?php

namespace Rocky\LaravelTwilio\Contracts;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 */
class FaxDeliveryReport
{
    private $faxSid;
    private $faxStatus;
    private $accountSid;

    /**
     * FaxDeliveryReport constructor.
     *
     * @param $accountSid
     * @param $faxSid
     * @param $faxStatus
     */
    public function __construct($accountSid, $faxSid, $faxStatus)
    {

        $this->faxSid     = $faxSid;
        $this->faxStatus  = $faxStatus;
        $this->accountSid = $accountSid;
    }

    /**
     * @return mixed
     */
    public function getAccountSid()
    {
        return $this->accountSid;
    }

    /**
     * @return string
     */
    public function getFaxSid()
    {
        return $this->faxSid;
    }

    /**
     * @return string
     */
    public function getFaxStatus()
    {
        return $this->faxStatus;
    }
}
