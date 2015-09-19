<?php

namespace Coreplex\Notifier\Session;

use Coreplex\Notifier\Contracts\Session;

class Native implements Session
{
    /**
     * The notifier config.
     *
     * @var array
     */
    protected $config = [];

    /**
     * An array of flashed data.
     *
     * @var array
     */
    protected $flash = [];

    /**
     * Flag to state if this is the first time the class has be instantiated.
     *
     * @var bool
     */
    protected $initialLoad = true;

    public function __construct(array $config)
    {
        $this->config = $config;
        if ( ! isset($_SESSION)) {
            session_start();
        }
        if ($this->initialLoad) {
            if (
                isset($_SESSION[$this->config['sessionKey']]) &&
                isset($_SESSION[$this->config['sessionKey']]['flash'])
            ) {
                $this->flash = $_SESSION[$this->config['sessionKey']]['flash'];
                unset($_SESSION[$this->config['sessionKey']]['flash']);
            }
            $this->initialLoad = false;
        }
    }

    /**
     * Check if an item exists in the session.
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        $session = $this->getSessionData();
        return array_key_exists($key, $session);
    }

    /**
     * Retrieve a property from the session by its key.
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $session = $this->getSessionData();
        return $session[$key];
    }

    /**
     * Put an item in the session.
     *
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        return $_SESSION[$this->config['sessionKey']][$key] = $value;
    }

    /**
     * Remove an item from the session.
     *
     * @param $key
     */
    public function forget($key)
    {
        if (
            isset($_SESSION[$this->config['sessionKey']]) &&
            isset($_SESSION[$this->config['sessionKey']][$key])
        ) {
            unset($_SESSION[$this->config['sessionKey']][$key]);
        }
        if (isset($this->flash[$key])) {
            unset($this->flash[$key]);
        }
    }

    /**
     * Flash an item to the session.
     *
     * @param $key
     * @param $value
     */
    public function flash($key, $value)
    {
        $_SESSION[$this->config['sessionKey']]['flash'][$key] = $value;
        $this->flash[$key] = $value;
    }

    /**
     * Merge all of the notifier session data and any flashed data.
     *
     * @return array
     */
    protected function getSessionData()
    {
        $data = isset($_SESSION[$this->config['sessionKey']]) ? $_SESSION[$this->config['sessionKey']] : [];
        return array_merge($data, $this->flash);
    }
}