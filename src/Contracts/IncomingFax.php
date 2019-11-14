<?php

namespace Rocky\LaravelTwilio\Contracts;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 */
class IncomingFax
{
    private $from;
    private $to;
    private $accountSid;
    private $faxSid;
    private $mediaUrl;

    /**
     * IncomingMessage constructor.
     *
     * @param $from
     * @param $to
     * @param $accountSid
     * @param $faxSid
     * @param $mediaUrl
     */
    public function __construct($from, $to, $accountSid, $faxSid, $mediaUrl)
    {

        $this->from       = $from;
        $this->to         = $to;
        $this->accountSid = $accountSid;
        $this->faxSid     = $faxSid;
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
    public function getFaxSid()
    {
        return $this->faxSid;
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->mediaUrl;
    }
}