<?php

namespace Rocky\LaravelTwilio\Foundation;

/**
 * Class TwilioCall
 *
 * @package Rocky\LaravelTwilio\Contracts
 *
 * @property string Caller
 * @property string Called
 * @property string CallSid
 * @property string CallStatus
 * @property string Digits
 */
abstract class TwilioCall extends TwilioResponse
{
    /**
     * @return bool
     */
    public function queued()
    {
        return $this->_isStatus('queued');
    }

    /**
     * @return bool
     */
    public function initiated()
    {
        return $this->_isStatus('initiated');
    }

    /**
     * @return bool
     */
    public function ringing()
    {
        return $this->_isStatus('ringing');
    }

    /**
     * @return bool
     */
    public function inProgress()
    {
        return $this->_isStatus('in-progress');
    }

    /**
     * @return bool
     */
    public function busy()
    {
        return $this->_isStatus('busy');
    }

    /**
     * @return bool
     */
    public function failed()
    {
        return $this->_isStatus('failed');
    }

    /**
     * @return bool
     */
    public function noAnswer()
    {
        return $this->_isStatus('no-answer');
    }

    /**
     * @return bool
     */
    public function completed()
    {
        return $this->_isStatus('completed');
    }

    /**
     * @param $status
     *
     * @return bool
     */
    private function _isStatus($status)
    {
        return $this->CallStatus === $status;
    }

    /**
     * @return bool
     */
    public function hungup()
    {
        return $this->Digits === 'hangup' && $this->completed();
    }
}
