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
 * @property string FromCity
 * @property string FromCountry
 * @property string FromState
 * @property string FromZip
 * @property string ToCity
 * @property string ToCountry
 * @property string ToState
 * @property string ToZip
 * @property string NumMedia
 * @property string NumSegments
 */
class IncomingMessage extends TwilioResponse
{

}