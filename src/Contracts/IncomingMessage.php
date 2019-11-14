<?php

namespace Rocky\LaravelTwilio\Contracts;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 */
class IncomingMessage
{
    private $from;
    private $to;
    private $accountSid;
    private $messageSid;
    private $body;
    private $mediaUrl;

    /**
     * IncomingMessage constructor.
     *
     * @param $from
     * @param $to
     * @param $accountSid
     * @param $messageSid
     * @param $body
     * @param $mediaUrl
     */
    public function __construct($from, $to, $accountSid, $messageSid, $body, $mediaUrl)
    {

        $this->from       = $from;
        $this->to         = $to;
        $this->accountSid = $accountSid;
        $this->messageSid = $messageSid;
        $this->body       = $body;
        $this->mediaUrl   = $mediaUrl;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return string
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
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }
}