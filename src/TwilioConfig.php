<?php

namespace Rocky\LaravelTwilio;

class TwilioConfig
{
    protected $config;

    /**
     * TwilioConfig constructor.
     *
     * @param  array  $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getSender() : string
    {
        return $this->config['caller_id'];
    }
}
