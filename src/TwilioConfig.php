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
     * @return mixed
     */
    public function getSender()
    {
        return $this->config['caller_id'];
    }
}
