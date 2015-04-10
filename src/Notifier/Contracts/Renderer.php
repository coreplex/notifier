<?php namespace Coreplex\Notifier\Contracts;

interface Renderer {

    /**
     * Render the notifications.
     *
     * @param array $data
     * @return string
     */
    public function render(array $data);

    /**
     * Set the template to be used by the renderer.
     *
     * @param $template
     * @return $this
     */
    public function setTemplate($template);

}