<?php

namespace Rocky\LaravelTwilio\Events;

use Exception;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class LaravelTwilioMessageSendingFailed
{
    use Dispatchable, SerializesModels;

    /**
     * @var Exception
     */
    private $exception;
    /**
     * @var
     */
    private $notifiable;

    /**
     * @var Notification
     */
    private $notification;

    /**
     * TwilioNotificationFailed constructor.
     *
     * @param  Exception  $exception
     * @param  $notifiable
     * @param  Notification  $notification
     */
    public function __construct(Exception $exception, $notifiable, Notification $notification)
    {
        $this->exception    = $exception;
        $this->notifiable   = $notifiable;
        $this->notification = $notification;
    }

    /**
     * @return Exception
     */
    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * @return mixed
     */
    public function getNotifiable()
    {
        return $this->notifiable;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }
}
