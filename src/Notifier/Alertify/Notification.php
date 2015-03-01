<?php namespace Michaeljennings\Notifier\Alertify;

use Illuminate\Support\Fluent;
use Michaeljennings\Notifier\Contracts\Notification as NotificationInterface;

class Notification extends Fluent implements NotificationInterface {

    public function __construct(array $properties)
    {
        $properties['alertifyLevel'] = $this->getAlertifyLevel($properties['level']);

        parent::__construct($properties);
    }

    /**
     * Render the notification into a JavaScript function.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('notifier::alertify.notification', ['notification' => $this]);
    }

    /**
     * Return which growl level to use for the notifier notification levels.
     *
     * @param $level
     * @return null|string
     */
    private function getAlertifyLevel($level)
    {
        if ($level == 'success') {
            return '.success';
        } elseif ($level == 'error') {
            return '.error';
        } elseif ($level == 'warning') {
            return '.log';
        }

        return '.log';
    }

}