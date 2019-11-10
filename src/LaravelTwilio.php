<?php

namespace Rocky\LaravelTwilio;

use Rocky\LaravelTwilio\Services\TwilioService;

class LaravelTwilio
{
    /**
     * @var TwilioService
     */
    protected $twilioService;

    /**
     * @var TwilioConfig
     */
    private $twilioConfig;

    public function __construct(TwilioService $twilioService, TwilioConfig $twilioConfig)
    {
        $this->twilioService = $twilioService;
        $this->twilioConfig  = $twilioConfig;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->twilioConfig->getSender();
    }

    /**
     * @return TwilioService
     */
    public function getTwilioService()
    {
        return $this->twilioService;
    }
}