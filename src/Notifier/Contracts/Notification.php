<?php namespace Coreplex\Notifier\Contracts;

interface Notification {

    /**
     * Render the notification data to a javascript function.
     *
     * @return mixed
     */
    public function render();

}
