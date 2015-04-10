<?php namespace Coreplex\Notifier\Contracts;

interface Session {

    /**
     * Check if an item exists in the session.
     *
     * @param $key
     * @return bool
     */
    public function has($key);

    /**
     * Retrieve a property from the session by its key.
     *
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * Put an item in the session.
     *
     * @param $key
     * @param $value
     */
    public function put($key, $value);

    /**
     * Remove an item from the session.
     *
     * @param $key
     */
    public function forget($key);

    /**
     * Flash an item to the session.
     *
     * @param $key
     * @param $value
     */
    public function flash($key, $value);

}