<?php

namespace Rocky\LaravelTwilio\Foundation;

/**
 * Class TwilioCall
 *
 * @package Rocky\LaravelTwilio\Contracts
 */
abstract class TwilioCall
{
    private $from;
    private $to;
    private $accountSid;
    private $callSid;
    private $status;

    /**
     * InboundCall constructor.
     *
     * @param $from
     * @param $to
     * @param $accountSid
     * @param $callSid
     * @param $status
     */
    public function __construct($from, $to, $accountSid, $callSid, $status)
    {

        $this->from       = $from;
        $this->to         = $to;
        $this->accountSid = $accountSid;
        $this->callSid    = $callSid;
        $this->status     = $status;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
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
    public function getStatus()
    {
        return $this->status;
    }
}