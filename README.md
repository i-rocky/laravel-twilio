## laravel-twilio

### Installation

Run the following commands

`composer require i-rocky/laravel-twilio`

`php artisan laravel-twilio:install`

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
TWIML_APP_SID= #you need to create a TwiML app for calling from browser

LARAVEL_TWILIO_BASE_URL=laravel-twilio #URL prefix for laravel-twilio 
LARAVEL_TWILIO_ENABLE_CALL=true
LARAVEL_TWILIO_RECORD_CALL=true
LARAVEL_TWILIO_REJECT_CALL_MESSAGE="Thank you for calling us" #reject incoming calls with this message when calling is disabled
LARAVEL_TWILIO_REPLY_MESSAGE=null #reply to incoming messages, null for no reply
MIX_LARAVEL_TWILIO_BASE_URL="${LARAVEL_TWILIO_BASE_URL}"
```

> [Create TwiML App here](https://www.twilio.com/console/phone-numbers/runtime/twiml-apps)

Now you have to set the Webhook URL in Twilio console.

> Change `laravel-twilio` in the Webhook URL with the base URL you've set for `LARAVEL_TWILIO_BASE_URL` in `.env`

#### Incoming Calls
Go to your phone number configuration from [Active Numbers](https://www.twilio.com/console/phone-numbers/incoming) then click on the desired number.

1. Under `Voice & Fax` for `Accept Incoming` select `Voice Calls`
2. Under `Configure With` select `Webhooks, TwiML Bins, Functions, Studio, or Proxy`
3. Under `A Call Comes In` select `Webhook` and set the value to `https://your-domain.tld/laravel-twilio/voice/incoming`

#### Incoming Messages
Go to your phone number configuration from [Active Numbers](https://www.twilio.com/console/phone-numbers/incoming) then click on the desired number.

1. Under `Configure With` select `Webhooks, TwiML Bins, Functions, Studio, or Proxy`
2. Under `A Message Comes In` select `Webhook` and set the value to `https://your-domain.tld/laravel-twilio/message/incoming`

#### Outgoing Calls

Go to [TwiML Apps](https://www.twilio.com/console/phone-numbers/runtime/twiml-apps) list and select desired one

1. Under `Voice` set the `REQUEST URI` to `https://your-domain.tld/laravel-twilio/voice`

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

* `LaravelTwilioIncomingMessage::class` [gives access to `IncomingMessage` at `$event->getMessage()`]
* `LaravelTwilioMessageSent::class` [gives access to `InstanceResource` at `$event->getMessage()` and `$notifiable` at `$event->getNotifiable()`]
* `LaravelTwilioMessageSendingFailed::class` [gives access to `Exception` at `$event->getException()`, `Notification` at `$event->getNotification()`, `$notifiable` at `$event->getNotifiable()`]
* `LaravelTwilioMessageDeliveryReport::class` [gives access to `MessageDeliveryReport` at `$event->getReport()`]
* `LaravelTwilioIncomingFax::class` [gives access to `IncomingFax` at `$event->getFax()`]
* `LaravelTwilioIncomingFax::class` [gives access to `IncomingFax` at `$event->getFax()`]
* `LaravelTwilioInboundCall::class` [gives access to `InboundCall` at `$event->getCall()`]
* `LaravelTwilioInboundCallRejected::class` [gives access to `InboundCall` at `$event->getCall()`]
* `LaravelTwilioOutboundCall::class` [gives access to `OutboundCall` at `$event->getCall()`]
* `LaravelTwilioCallStatusUpdate::class` [gives access to `CallStatus` at `$event->getStatus()`]
* `LaravelTwilioCallRecord::class` [gives access to `CallRecord` at `$event->getRecord()`]

All the properties sent by Twilio are available in the instance passed through Event. Some of the frequently used properties are added for autocomplete.

Look into the source code for a clearer understanding.
