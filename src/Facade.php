<?php

namespace Rocky\LaravelTwilio;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return LaravelTwilio::class;
    }
}