<?php

namespace Rocky\LaravelTwilio\Exceptions;

use Exception;

class MessageTypeUndefinedException extends Exception
{
    protected $code = 0x00005;
    protected $message = 'The message type has not been set.';
}
