<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioResponse;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 *
 * @property string FaxSid
 * @property string MediaUrl
 * @property string OriginalMediaUrl
 */
class IncomingFax extends TwilioResponse
{

}