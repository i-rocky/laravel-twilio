<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioCall;

/**
 * Class CallStatus
 *
 * @package Rocky\LaravelTwilio\Contracts
 *
 * @property string CallDuration
 * @property string ParentCallSid
 * @property string CallbackSource
 * @property string SequenceNumber
 * @property string Direction
 */
class CallStatus extends TwilioCall
{

}
