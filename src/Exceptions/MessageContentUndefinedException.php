<?php

namespace Rocky\LaravelTwilio\Exceptions;

use Exception;

class MessageContentUndefinedException extends Exception
{
    protected $code = 0x00002;
    protected $message = 'No message content has been defined';
}
