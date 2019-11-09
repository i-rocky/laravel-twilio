## laravel-twilio

### Installation

`composer require i-rocky/laravel-twilio`

### Usage

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

...

}
```

### Events
* `TwilioNotificationSuccess::class` [gives access to `InstanceResource` at `$event->message`]
* `TwilioNotificationFailed::class` [gives access to `Exception` at `$event->exception`]