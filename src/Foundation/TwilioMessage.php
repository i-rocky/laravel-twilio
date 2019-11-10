<?php

namespace Rocky\LaravelTwilio\Foundation;

use Rocky\LaravelTwilio\Exceptions\MediaUrlUndefinedException;
use Rocky\LaravelTwilio\Exceptions\MessageContentUndefinedException;
use Rocky\LaravelTwilio\Exceptions\MessageNotStoredException;
use Rocky\LaravelTwilio\Exceptions\MessageTypeUndefinedException;
use Rocky\LaravelTwilio\Exceptions\ReceiverUndefinedException;
use Rocky\LaravelTwilio\LaravelTwilio;
use Rocky\LaravelTwilio\Models\LaravelTwilioMessage;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

abstract class TwilioMessage
{
    private $_sender;
    private $_receiver;
    protected $_contentRequired = false;
    private $_content;
    protected $_mediaUrlRequired = false;
    private $_mediaUrl;
    protected $_type;
    /** @var LaravelTwilioMessage */
    protected $message;

    /**
     * For developers
     *
     * @return mixed
     * @throws MessageTypeUndefinedException
     */
    protected function _getType()
    {
        if ( ! $this->_type) {
            throw new MessageTypeUndefinedException();
        }

        return $this->_type;
    }

    /**
     * @param $sender
     *
     * @return TwilioMessage
     */
    public function from($sender)
    {
        $this->_sender = $sender;

        return $this;
    }

    /**
     * @param $receiver
     *
     * @return TwilioMessage
     */
    public function to($receiver)
    {
        $this->_receiver = $receiver;

        return $this;
    }

    /**
     * @param $content
     *
     * @return TwilioMessage
     */
    public function text($content)
    {
        $this->_content = $content;

        return $this;
    }

    /**
     * @param $url
     *
     * @return $this
     */
    public function mediaUrl($url)
    {
        $this->_mediaUrl = $url;

        return $this;
    }

    /**
     * @return mixed
     * @throws MediaUrlUndefinedException
     */
    protected function _getMediaUrl()
    {
        if ( ! $this->_mediaUrl && $this->_mediaUrlRequired) {
            throw new MediaUrlUndefinedException();
        }

        return $this->_mediaUrl;
    }

    /**
     * @return mixed
     * @throws MessageContentUndefinedException
     */
    protected function _getContent()
    {
        if ( ! $this->_content && $this->_contentRequired) {
            throw new MessageContentUndefinedException();
        }

        return $this->_content;
    }

    /**
     * @param $notifiable
     *
     * @return string
     * @throws ReceiverUndefinedException
     */
    protected function _getReceiver($notifiable)
    {
        // check if the receiver explicitly set
        if ($this->_receiver) {
            return $this->_receiver;
        }
        // check if we have route
        if ($notifiable->routeNotificationFor('twilio')) {
            return $notifiable->routeNotificationFor('twilio');
        }
        // look for phone field
        if ($notifiable->phone) {
            return $notifiable->phone;
        }
        // look for phone number field
        if ($notifiable->phone_number) {
            return $notifiable->phone_number;
        }
        // no luck

        throw new ReceiverUndefinedException();
    }

    /**
     * @param  LaravelTwilio  $laravelTwilio
     *
     * @return string
     */
    protected function _getSender(LaravelTwilio $laravelTwilio)
    {
        return $this->_sender ?: $laravelTwilio->getSender();
    }

    /**
     * @param $notifiable
     * @param  LaravelTwilio  $laravelTwilio
     *
     * @return void
     * @throws MessageTypeUndefinedException
     * @throws ReceiverUndefinedException
     */
    protected function storeMessage($notifiable, LaravelTwilio $laravelTwilio)
    {
        $message = new LaravelTwilioMessage();
        $message->fill([
            'type'     => $this->_getType(),
            'receiver' => $this->_getReceiver($notifiable),
            'sender'   => $this->_getSender($laravelTwilio),
            'text'     => $this->_content,
            'mediaUrl' => $this->_mediaUrl,
        ]);
        $message->save();

        $this->message = $message;
    }

    /**
     * @return string
     * @throws MessageNotStoredException
     */
    protected function _getStatusCallbackRoute()
    {
        if ( ! $this->message) {
            throw new MessageNotStoredException();
        }

        return route('api.laravel-twilio.report', ['laravel_twilio_message' => $this->message->id]);
    }

    /**
     * @param $notifiable
     * @param  LaravelTwilio  $laravelTwilio
     *
     * @return LaravelTwilioMessage
     * @throws MessageTypeUndefinedException
     * @throws ReceiverUndefinedException
     */
    public function send($notifiable, LaravelTwilio $laravelTwilio)
    {
        $this->storeMessage($notifiable, $laravelTwilio);

        $response = $this->_send($notifiable, $laravelTwilio);

        $this->message->update([
            'status'   => $response->status,
            'response' => $response->toArray(),
        ]);

        return $this->message;
    }

    /**
     * @param $notifiable
     * @param  LaravelTwilio  $laravelTwilio
     *
     * @return MessageInstance
     */
    abstract protected function _send($notifiable, LaravelTwilio $laravelTwilio);
}
