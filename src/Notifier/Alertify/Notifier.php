<?php namespace Coreplex\Notifier\Alertify;

use Coreplex\Notifier\AbstractNotifier;

class Notifier extends AbstractNotifier {

    /**
     * Set the template being used for the notifier.
     *
     * @return \Illuminate\View\View
     */
    public function getTemplate()
    {
        return $this->config['views']['alertify']['template'];
    }

    /**
     * Return an array of styles to be inculded on the frontend.
     *
     * @return array
     */
    protected function getStyles()
    {
        return $this->config['assets']['alertify']['css'];
    }

    /**
     * Return an array of scripts to be included on the frontend.
     *
     * @return array
     */
    protected function getScripts()
    {
        return $this->config['assets']['alertify']['js'];
    }

    /**
     * Get the notification class for the notifier.
     *
     * @param array $properties
     * @return \Coreplex\Contracts\Notifier\Notification
     */
    protected function newNotification(array $properties)
    {
        return new Notification($properties, $this);
    }

}