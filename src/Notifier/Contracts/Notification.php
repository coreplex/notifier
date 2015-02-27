<?php namespace Michaeljennings\Contracts\Notifier;

interface Notification {

    /**
     * Render the notification data to a javascript function.
     *
     * @return mixed
     */
    public function render();

}
