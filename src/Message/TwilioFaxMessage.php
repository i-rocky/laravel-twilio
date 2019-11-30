<?php

namespace Rocky\LaravelTwilio\Message;

use Rocky\LaravelTwilio\Exceptions\MediaUrlUndefinedException;
use Rocky\LaravelTwilio\Exceptions\ReceiverUndefinedException;
use Rocky\LaravelTwilio\Foundation\TwilioMessage;
use Rocky\LaravelTwilio\LaravelTwilio;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Fax\V1\FaxInstance;

class TwilioFaxMessage extends TwilioMessage
{
    protected $_mediaUrlRequired = true;
    protected $_type = 'Fax';

    /**
     * @return string
     */
    protected function _getStatusCallbackRoute(): string
    {
        return route('api.laravel-twilio.fax.report');
    }

    /**
     * @param $notifiable
     * @param  LaravelTwilio  $laravelTwilio
     *
     * @return FaxInstance
     * @throws MediaUrlUndefinedException
     * @throws ReceiverUndefinedException
     * @throws TwilioException
     */
    public function send($notifiable, LaravelTwilio $laravelTwilio)
    {
        $receiver = $this->_getReceiver($notifiable);
        $sender   = $this->_getSender($laravelTwilio);
        $mediaUrl = $this->_getMediaUrl();

        return $laravelTwilio
            ->getTwilioService()
            ->fax
            ->v1
            ->faxes
            ->create($receiver, $mediaUrl, [
                'from'           => $sender,
                'statusCallback' => $this->_getStatusCallbackRoute(),
            ]);
    }
}
