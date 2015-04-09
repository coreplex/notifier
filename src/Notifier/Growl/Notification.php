<?php namespace Coreplex\Notifier\Growl;

use Illuminate\Support\Fluent;
use Coreplex\Notifier\Contracts\Notification as NotificationInterface;

class Notification extends Fluent implements NotificationInterface {

    public function __construct(array $properties)
    {
        if ( ! empty($properties['level'])) {
            $properties['growlLevel'] = $this->getGrowlLevel($properties['level']);
        }

        parent::__construct($properties);
    }

    /**
     * Render the notification into a JavaScript function.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('notifier::growl.notification', ['notification' => $this])->render();
    }

    /**
     * Return which growl level to use for the notifier notification levels.
     *
     * @param $level
     * @return null|string
     */
    private function getGrowlLevel($level)
    {
        if ($level == 'success') {
            return '.notice';
        } elseif ($level == 'error') {
            return '.error';
        } elseif ($level == 'warning') {
            return '.warning';
        }

        return null;
    }

}