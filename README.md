## laravel-twilio

### Installation

Run the following commands

`composer require i-rocky/laravel-twilio`

`php artisan laravel-twilio:install`

This should publish the following files

```tree
project
|   config
|   |   laravel-twilio.php
|
└───resources
    └───assets
        └───js
            └───vendor
                └───laravel-twilio
                    └───mappers
                    |       ResponseMapper.js //maps the response into Response instance
                    |
                    └───models
                    |       Response.js //response model
                    |
                    └───services
                            HttpService.js //proxy for axios requests
                            TwilioService.js //wrapper for twilio client
```

> To use `TwilioService.js` run `yarn add axios twilio-client`

You can add/update/remove/move the files and use as your wish
### Setup

Update `config/services.php`
```php
...   
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token'  => env('TWILIO_AUTH_TOKEN'),
        'caller_id'   => env('TWILIO_NUMBER'),
        'username'    => env('TWILIO_USERNAME'),
        'password'    => env('TWILIO_PASSWORD'),
        'app_sid'     => env('TWIML_APP_SID'),
    ],
...
```

Update `.env`
```dotenv
TWILIO_ACCOUNT_SID=
TWILIO_AUTH_TOKEN=
TWILIO_NUMBER=
TWIML_APP_SID=

LARAVEL_TWILIO_BASE_URL=laravel-twilio 
LARAVEL_TWILIO_ENABLE_CALL=true
LARAVEL_TWILIO_RECORD_CALL=true
LARAVEL_TWILIO_REJECT_CALL_MESSAGE="Thank you for calling us"
LARAVEL_TWILIO_REPLY_MESSAGE=null
MIX_LARAVEL_TWILIO_BASE_URL="${LARAVEL_TWILIO_BASE_URL}"
```

* `TWIML_APP_SID` - you need to create a TwiML app for calling from browser
* `LARAVEL_TWILIO_BASE_URL` - URL prefix for laravel-twilio
* `LARAVEL_TWILIO_REJECT_CALL_MESSAGE` - reject incoming calls with this message when calling is disabled
* `LARAVEL_TWILIO_REPLY_MESSAGE` - reply to incoming messages, null for no reply 

Now you have to set the Webhook URL in Twilio console.

> Replace `laravel-twilio` in the Webhook URL with the base URL you've set for `LARAVEL_TWILIO_BASE_URL` in `.env`

#### Incoming Calls
Go to your phone number configuration from [Active Numbers](https://www.twilio.com/console/phone-numbers/incoming) then click on the desired number.

1. Under `Voice & Fax` for `Accept Incoming` select `Voice Calls`
2. Under `Configure With` select `Webhooks, TwiML Bins, Functions, Studio, or Proxy`
3. Under `A Call Comes In` select `Webhook` and set the value to `https://your-domain.tld/api/laravel-twilio/voice/incoming`

#### Incoming Messages
Go to your phone number configuration from [Active Numbers](https://www.twilio.com/console/phone-numbers/incoming) then click on the desired number.

1. Under `Configure With` select `Webhooks, TwiML Bins, Functions, Studio, or Proxy`
2. Under `A Message Comes In` select `Webhook` and set the value to `https://your-domain.tld/api/laravel-twilio/message/incoming`

#### Outgoing Calls

Go to [TwiML Apps](https://www.twilio.com/console/phone-numbers/runtime/twiml-apps) list and select desired app or create a new app

1. Under `Voice` set the `REQUEST URI` to `https://your-domain.tld/api/laravel-twilio/voice`

### Usage

Implement `Notifiable`
```php
/**
 * @property string username
 * @property string phone
 * @property string phone_number
 */
clas User extends Authenticable {
    use Notifiable;

...

    public function routeNotificationForTwilio() {
        return "+{$this->phone}";
    }
    
    public function laravelTwilioIdentity() {
        return Str::snake($this->first_name);
    }
}
```


Implement notification
```php

use Rocky\LaravelTwilio\Foundation\TwilioMessage;
use Rocky\LaravelTwilio\Message\TwilioSMSMessage;
use Rocky\LaravelTwilio\Message\TwilioMMSMessage;
use Rocky\LaravelTwilio\Message\TwilioFaxMessage;
use Rocky\LaravelTwilio\Message\TwilioCallMessage;
use Rocky\LaravelTwilio\TwilioChannel;

class TwilioTestNotification extends Notification {

...

    public function via($notifiable) {
        return [TwilioChannel::class];
    }

...

    public function toTwilio($notifiable) {
        // SMS
        return (new TwilioSMSMessage())
            ->to('+receiver') // optional
            ->from('+sender') // optional
            ->text('Your message'); // required
    
        // MMS (only works for Canada and US number)
        return (new TwilioMMSMessage())
            ->to('+receiver') // optional
            ->from('+sender') // optional
            ->text('Your message') // optional
            ->mediaUrl('publicly accessible media url'); // required
    
        // Call
        return (new TwilioCallMessage())
            ->to('+receiver') // optional
            ->from('+sender') // optional
            ->mediaUrl('publicly accessible media'); // required
    
        // Fax
        return (new TwilioSMSMessage())
            ->to('+receiver') // optional
            ->from('+sender') // optional
            ->mediaUrl('publicly accessible media url'); // required
    }
}
```

> If you don't use the `to('+number')` method in your message construction, you must have `phone`, `phone_number` property or `routeNotificationForTwilio()` method implemented in your `Notifiable` implementation. The number must start with `+` followed by country code.

> If you don't have `username` property definition in your Auth provider model, you must implement `laravelTwilioIdentity()` method to give your agents an identity for calling.

### Events

Namespace `Rocky\LaravelTwilio\Events`

* `LaravelTwilioIncomingMessage::class` [gives access to `IncomingMessage` at `$event->getMessage()`]
* `LaravelTwilioIncomingFax::class` [gives access to `IncomingFax` at `$event->getFax()`]
* `LaravelTwilioMessageSent::class` [gives access to `InstanceResource` at `$event->getMessage()` and `$notifiable` at `$event->getNotifiable()`]
* `LaravelTwilioMessageSendingFailed::class` [gives access to `Exception` at `$event->getException()`, `Notification` at `$event->getNotification()`, `$notifiable` at `$event->getNotifiable()`]
* `LaravelTwilioMessageDeliveryReport::class` [gives access to `MessageDeliveryReport` at `$event->getReport()`]
* `LaravelTwilioFaxDeliveryReport::class` [gives access to `FaxDeliveryReport` at `$event->getReport()`]
* `LaravelTwilioInboundCall::class` [gives access to `InboundCall` at `$event->getCall()`]
* `LaravelTwilioInboundCallRejected::class` [gives access to `InboundCall` at `$event->getCall()`]
* `LaravelTwilioOutboundCall::class` [gives access to `OutboundCall` at `$event->getCall()`]
* `LaravelTwilioCallStatusUpdate::class` [gives access to `CallStatus` at `$event->getStatus()`]
* `LaravelTwilioCallRecord::class` [gives access to `CallRecord` at `$event->getRecord()`]

All the parameters sent by Twilio are available in the instance passed through Event. Some of the frequently used properties are added for autocomplete support.

Example:
```php
$call = $event->getCall();

$sid = $call->CallSid;
$sid = $call->callSid;
$sid = $call->call_sid;

$from = $call->From;
$from = $call->from;

$allParams = $call->all();

```

Look into the source code for a clearer understanding.
