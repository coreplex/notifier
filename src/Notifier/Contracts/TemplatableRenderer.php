<?php namespace Coreplex\Notifier\Contracts;

interface TemplatableRenderer extends Renderer {

    /**
     * Set the template to be used by the renderer.
     *
     * @param $template
     * @return $this
     */
    public function setTemplate($template);

}