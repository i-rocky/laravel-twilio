<?php

namespace Rocky\LaravelTwilio\Exceptions;

use Exception;

class IdentityMethodNotImplementedException extends Exception
{
    protected $code = 0x00006;
    protected $message = 'Property `username` does not exist and the method `laravelTwilioIdentity()` is not implemented';
}
