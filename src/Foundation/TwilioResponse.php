<?php

namespace Rocky\LaravelTwilio\Foundation;

use Illuminate\Support\Collection;

/**
 * Class TwilioResponse
 *
 * @package Rocky\LaravelTwilio\Foundation
 *
 * @property string To
 * @property string From
 * @property string ApplicationSid
 * @property string AccountSid
 */
abstract class TwilioResponse
{
    /** @var Collection */
    protected $response;

    /**
     * TwilioCall constructor.
     *
     * @param  array  $response
     */
    public function __construct(array $response)
    {

        $this->response = collect($response);
    }

    /**
     * @return Collection
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $name
     *
     * @return string|null
     */
    public function __get($name)
    {
        if ($this->response->has($name)) {
            return $this->response->get($name);
        }

        return null;
    }

    /**
     * @param $name
     * @param $default
     *
     * @return string|null
     */
    public function __call($name, $default)
    {
        if ($this->response->has($name)) {
            return $this->response->get($name);
        }

        return $default;
    }
}
