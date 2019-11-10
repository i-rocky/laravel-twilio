<?php

namespace Rocky\LaravelTwilio\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LaravelTwilioMessage
 *
 * @package Rocky\LaravelTwilio\Models
 *
 * @property int id
 * @property string type
 * @property string receiver
 * @property string sender
 * @property string text
 * @property string mediaUrl
 * @property string status
 * @property string response
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class LaravelTwilioMessage extends Model
{
    protected $fillable = [
        'type', // sms, fax, mms
        'receiver',
        'sender',
        'text',
        'mediaUrl',
        'status',
        'response',
    ];
}
