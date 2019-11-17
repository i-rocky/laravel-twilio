<?php

namespace Rocky\LaravelTwilio\Contracts;

use Rocky\LaravelTwilio\Foundation\TwilioCall;

/**
 * Class CallRecord
 *
 * @package Rocky\LaravelTwilio\Contracts
 *
 * @property string RecordingSource
 * @property string RecordingSid
 * @property string RecordingUrl
 * @property string RecordingStatus
 * @property string RecordingDuration
 * @property string RecordingChannels
 * @property string ErrorCode
 */
class CallRecord extends TwilioCall
{

}
