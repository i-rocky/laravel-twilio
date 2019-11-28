<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioResponse;

/**
 * Class IncomingMessage
 *
 * @package Rocky\LaravelTwilio\Contracts
 *
 * @property string MessageSid
 * @property string MessageStatus
 */
class MessageDeliveryReport extends TwilioResponse
{

}
