<?php

namespace Rocky\LaravelTwilio\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Rocky\LaravelTwilio\Contracts\IncomingFax;

class LaravelTwilioIncomingFax
{
    use Dispatchable, SerializesModels;

    /**
     * @var IncomingFax
     */
    private $fax;

    /**
     * LaravelTwilioIncomingMessage constructor.
     *
     * @param  IncomingFax  $fax
     */
    public function __construct(IncomingFax $fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return IncomingFax
     */
    public function getFax(): IncomingFax
    {
        return $this->fax;
    }
}
