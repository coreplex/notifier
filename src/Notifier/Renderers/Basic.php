<?php namespace Coreplex\Notifier\Renderers; 

use Coreplex\Notifier\Contracts\Renderer;

class Basic implements Renderer {

    /**
     * The template to be rendered.
     *
     * @var string
     */
    protected $template;

    public function __construct()
    {}

    /**
     * Render the notifications.
     *
     * @param array $data
     * @return string
     */
    public function render(array $data)
    {
        $template = $this->template;

        if ( ! file_exists($template)) {
            dd('template does not exist');
        }

        // Extract the passed variables
        extract($data);

        // include the template
        include ($template);

        // Get the content
        $content = ob_get_contents();
        // Clear the output buffer
        ob_end_clean();

        // Return the content
        return $content;
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