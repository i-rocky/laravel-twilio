## laravel-twilio

### Installation

`composer require i-rocky/laravel-twilio`

### Usage

Update `config/service.php`
```php
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token'  => env('TWILIO_AUTH_TOKEN'),
        'from'        => env('TWILIO_NUMBER'),
        'username' => env('TWILIO_USERNAME'),
        'password' => env('TWILIO_PASSWORD'),
    ],
```

Update `.env`
```dotenv
TWILIO_ACCOUNT_SID=
TWILIO_AUTH_TOKEN=
TWILIO_NUMBER=
#TWILIO_USERNAME=
#TWILIO_PASSWORD=
```

Implement `Notifiable`
```php
/**
 * @property string phone
 * @property string phone_number
 */
clas User extends Authenticable {
    use Notifiable;

...

    public function routeNotificationForTwilio() {
        return "+{$this->phone}";
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

> If you don't use the `->to('+number')` method in your message construction, you must have `phone`, `phone_number` property or `routeNotificationForTwilio()` method implemented in your `Notifiable` implementation. The number must start with `+` followed by country code.

### Events
* `TwilioNotificationSuccess::class` [gives access to `InstanceResource` at `$event->message`]
* `TwilioNotificationFailed::class` [gives access to `Exception` at `$event->exception`]