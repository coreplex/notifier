<?php namespace Michaeljennings\Notifier\Growl;

use Michaeljennings\Notifier\AbstractNotifier;

class Notifier extends AbstractNotifier {

    /**
     * Set the template being used for the notifier.
     *
     * @return \Illuminate\View\View
     */
    public function setTemplate()
    {
        return view('notifier::growl.default');
    }

    /**
     * Return an array of styles to be inculded on the frontend.
     *
     * @return array
     */
    protected function getStyles()
    {
        return ['css/jquery.growl.css'];
    }

    /**
     * Return an array of scripts to be included on the frontend.
     *
     * @return array
     */
    protected function getScripts()
    {
        return ['js/jquery.growl.js'];
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