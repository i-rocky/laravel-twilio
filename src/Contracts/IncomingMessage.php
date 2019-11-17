<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioResponse;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 *
 * @property string MessageSid
 * @property string Body
 * @property string OriginalMediaUrl
 * @property string MediaUrl
 */
class IncomingMessage extends TwilioResponse
{

}