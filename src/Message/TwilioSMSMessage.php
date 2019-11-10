<?php

namespace Rocky\LaravelTwilio\Message;

use Rocky\LaravelTwilio\Exceptions\MessageContentUndefinedException;
use Rocky\LaravelTwilio\Exceptions\MessageNotStoredException;
use Rocky\LaravelTwilio\Exceptions\ReceiverUndefinedException;
use Rocky\LaravelTwilio\Foundation\TwilioMessage;
use Rocky\LaravelTwilio\LaravelTwilio;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

class TwilioSMSMessage extends TwilioMessage
{
    protected $_contentRequired = true;
    protected $_type = 'SMS';

    /**
     * @param $notifiable
     * @param  LaravelTwilio  $laravelTwilio
     *
     * @return MessageInstance
     * @throws MessageContentUndefinedException
     * @throws ReceiverUndefinedException
     * @throws TwilioException
     * @throws MessageNotStoredException
     */
    protected function _send($notifiable, LaravelTwilio $laravelTwilio)
    {
        $receiver = $this->_getReceiver($notifiable);
        $sender   = $this->_getSender($laravelTwilio);
        $content  = $this->_getContent();

        return $laravelTwilio
            ->getTwilioService()
            ->messages
            ->create($receiver, [
                'body'           => $content,
                'from'           => $sender,
                'statusCallback' => $this->_getStatusCallbackRoute(),
            ]);
    }
}
