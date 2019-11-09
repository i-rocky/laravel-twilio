<?php

namespace Rocky\LaravelTwilio\Exceptions;

use Exception;

class ReceiverUndefinedException extends Exception
{
    protected $code = 0x00001;
    protected $message = 'No receiver has been defined';
}
