<?php

namespace Rocky\LaravelTwilio\Contracts;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 */
class MessageDeliveryReport
{
    private $messageSid;
    private $messageStatus;
    private $accountSid;

    /**
     * MessageDeliveryReport constructor.
     *
     * @param $accountSid
     * @param $messageSid
     * @param $messageStatus
     */
    public function __construct($accountSid, $messageSid, $messageStatus)
    {

        $this->messageSid    = $messageSid;
        $this->messageStatus = $messageStatus;
        $this->accountSid    = $accountSid;
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
    public function getMessageSid()
    {
        return $this->messageSid;
    }

    /**
     * @return string
     */
    public function getMessageStatus()
    {
        return $this->messageStatus;
    }
}
