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

    public function getSender()
    {
        return $this->config['from'];
    }
}
