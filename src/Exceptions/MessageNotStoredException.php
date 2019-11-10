<?php

namespace Rocky\LaravelTwilio\Exceptions;

use Exception;

class MessageNotStoredException extends Exception
{
    protected $code = 0x00004;
    protected $message = 'The message has not been stored yet. Please call storeMessage() method first.';
}
