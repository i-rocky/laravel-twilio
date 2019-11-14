<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioCall;

class CallStatus
{
    private $accountSid;
    private $callSid;
    private $callStatus;
    private $callDuration;

    /**
     * CallStatus constructor.
     *
     * @param $accountSid
     * @param $callSid
     * @param $callStatus
     * @param $callDuration
     */
    public function __construct($accountSid, $callSid, $callStatus, $callDuration)
    {

        $this->accountSid = $accountSid;
        $this->callSid    = $callSid;
        $this->callStatus = $callStatus;
        $this->callDuration = $callDuration;
    }

    /**
     * @return mixed
     */
    public function getCallDuration()
    {
        return $this->callDuration;
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