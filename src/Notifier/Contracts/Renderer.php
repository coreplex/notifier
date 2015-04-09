<?php namespace Coreplex\Notifier\Contracts;

interface Renderer {

    /**
     * Render the notifications.
     *
     * @param array $data
     * @return string
     */
    public function render(array $data);

}