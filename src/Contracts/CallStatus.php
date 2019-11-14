<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioCall;

class CallStatus
{
    private $accountSid;
    private $callSid;
    private $callStatus;

    /**
     * CallStatus constructor.
     *
     * @param $accountSid
     * @param $callSid
     * @param $callStatus
     */
    public function __construct($accountSid, $callSid, $callStatus)
    {

        $this->accountSid = $accountSid;
        $this->callSid    = $callSid;
        $this->callStatus = $callStatus;
    }

    /**
     * @return mixed
     */
    public function getAccountSid()
    {
        return $this->accountSid;
    }

    /**
     * @return mixed
     */
    public function getCallSid()
    {
        return $this->callSid;
    }

    /**
     * @return mixed
     */
    public function getCallStatus()
    {
        return $this->callStatus;
    }
}