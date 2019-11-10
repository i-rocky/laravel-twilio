<?php

namespace Rocky\LaravelTwilio\Events;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class TwilioNotificationFailed
{
    use SerializesModels;

    /**
     * @var Exception
     */
    public $exception;
    /**
     * @var
     */
    public $notifiable;
    /**
     * @var Notification
     */
    public $notification;

    /**
     * TwilioNotificationFailed constructor.
     *
     * @param  Exception  $exception
     * @param  $notifiable
     * @param  Notification  $notification
     */
    public function __construct(Exception $exception, $notifiable, Notification $notification)
    {
        $this->exception = $exception;
        $this->notifiable = $notifiable;
        $this->notification = $notification;
    }
}
