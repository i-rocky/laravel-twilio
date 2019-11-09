<?php

namespace Rocky\LaravelTwilio\Exceptions;

use Exception;

class MediaUrlUndefinedException extends Exception
{
    protected $code = 0x00003;
    protected $message = 'No media URL has been defined';
}
