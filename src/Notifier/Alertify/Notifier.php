<?php namespace Michaeljennings\Notifier\Alertify;

use Michaeljennings\Notifier\AbstractNotifier;

class Notifier extends AbstractNotifier {

    /**
     * Set the template being used for the notifier.
     *
     * @return \Illuminate\View\View
     */
    public function setTemplate()
    {
        return view('notifier::alertify.default');
    }

    /**
     * Return an array of styles to be inculded on the frontend.
     *
     * @return array
     */
    protected function getStyles()
    {
        return ['css/alertify.core.css', 'css/alertify.bootstrap.css'];
    }

    /**
     * Return an array of scripts to be included on the frontend.
     *
     * @return array
     */
    protected function getScripts()
    {
        return ['js/alertify.min.js'];
    }

    /**
     * Get the notification class for the notifier.
     *
     * @param array $properties
     * @return \Nexus\Contracts\Notifier\Notification
     */
    protected function newNotification(array $properties)
    {
        return new Notification($properties);
    }

}