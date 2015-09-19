<?php

namespace Coreplex\Notifier\Session;

use Illuminate\Session\Store;
use Coreplex\Notifier\Contracts\Session;

class Illuminate implements Session
{
    /**
     * An instance of the illuminate session store.
     *
     * @var Store
     */
    protected $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Check if an item exists in the session.
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return $this->session->has($key);
    }

    /**
     * Retrieve a property from the session by its key.
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->session->get($key);
    }

    /**
     * Put an item in the session.
     *
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        return $this->session->put($key, $value);
    }

    /**
     * Remove an item from the session.
     *
     * @param $key
     */
    public function forget($key)
    {
        return $this->session->forget($key);
    }

    /**
     * Flash an item to the session.
     *
     * @param $key
     * @param $value
     */
    public function flash($key, $value)
    {
        return $this->session->flash($key, $value);
    }
}