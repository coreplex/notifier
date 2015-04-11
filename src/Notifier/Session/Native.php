<?php namespace Coreplex\Notifier\Session; 

use Coreplex\Notifier\Contracts\Session;

class Native implements Session {

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
    private $flash = [];

    /**
     * Flag to state if this is the first time the class has be instantiated.
     *
     * @var bool
     */
    private $initialLoad = true;

    public function __construct(array $config)
    {
        $this->config = $config;

        if ($this->initialLoad) {
            if (isset($_SESSION[$this->config['sessionPrefix']]['flash'])) {
                $this->flash = $_SESSION[$this->config['sessionPrefix']]['flash'];
                unset($_SESSION[$this->config['sessionPrefix']]['flash']);
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
        return $_SESSION[$this->config['sessionPrefix']][$key] = $value;
    }

    /**
     * Remove an item from the session.
     *
     * @param $key
     */
    public function forget($key)
    {
        if (
            isset($_SESSION[$this->config['sessionPrefix']]) &&
            isset($_SESSION[$this->config['sessionPrefix']][$key])
        ) {
            unset($_SESSION[$this->config['sessionPrefix']][$key]);
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
        $_SESSION[$this->config['sessionPrefix']]['flash'][$key] = $value;
        $this->flash[$key] = $value;
    }

    /**
     * Merge all of the notifier session data and any flashed data.
     *
     * @return array
     */
    protected function getSessionData()
    {
        $data = $_SESSION[$this->config['sessionPrefix']];

        return array_merge($data, $this->flash);
    }

}