<?php namespace Coreplex\Notifier\Renderers; 

use Illuminate\View\Factory;
use Coreplex\Notifier\Contracts\TemplatableRenderer;

class LaravelBlade implements TemplatableRenderer {

    /**
     * The template to be used by the renderer.
     *
     * @var string
     */
    protected $template;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    /**
     * Render the notifications.
     *
     * @param array $data
     * @return string
     */
    public function render(array $data)
    {
        return $this->view->make($this->template)->with('notifications', $data)->render();
    }

    /**
     * Set the template to be used by the renderer.
     *
     * @param $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

}