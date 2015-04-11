<?php namespace Coreplex\Notifier\Growl;

use Coreplex\Notifier\AbstractNotifier;

class Notifier extends AbstractNotifier {

    /**
     * Get the template being used for the notifier.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->config['views']['growl']['template'];
    }

    /**
     * Return an array of styles to be inculded on the frontend.
     *
     * @return array
     */
    protected function getStyles()
    {
        return $this->config['assets']['growl']['css'];
    }

    /**
     * Return an array of scripts to be included on the frontend.
     *
     * @return array
     */
    protected function getScripts()
    {
        return $this->config['assets']['growl']['js'];
    }

    /**
     * Get the notification class for the notifier.
     *
     * @param array $properties
     * @return \Michaeljennings\Contracts\Notifier\Notification
     */
    protected function newNotification(array $properties)
    {
        return new Notification($properties, $this);
    }

}