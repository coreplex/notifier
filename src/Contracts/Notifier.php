<?php

namespace Coreplex\Notifier\Contracts;

interface Notifier
{
    /**
     * Add a new notification.
     *
     * @param string $level
     * @param array  $attributes
     * @return \Coreplex\Notifier\Notifier
     */
    public function notify($level, array $attributes = []);

    /**
     * Set a new info level notification.
     *
     * @param array $attributes
     * @return \Coreplex\Notifier\Notifier
     */
    public function info(array $attributes = []);

    /**
     * Set a new error level notification.
     *
     * @param array $attributes
     * @return \Coreplex\Notifier\Notifier
     */
    public function error(array $attributes = []);

    /**
     * Set a new success level notification.
     *
     * @param array $attributes
     * @return \Coreplex\Notifier\Notifier
     */
    public function success(array $attributes = []);

    /**
     * Render the notifications to javascript.
     *
     * @return string
     */
    public function render();

    /**
     * Render the notifier scripts.
     *
     * @return string
     */
    public function scripts();

    /**
     * Render the notifier styles.
     *
     * @return string
     */
    public function styles();

    /**
     * Set the notification driver.
     *
     * @param string $driver
     * @return \Coreplex\Notifier\Notifier
     */
    public function driver($driver);
}