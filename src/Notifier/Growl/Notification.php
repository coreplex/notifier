<?php namespace Coreplex\Notifier\Growl;

use Coreplex\Notifier\AbstractNotification;
use Coreplex\Notifier\Contracts\Notifier as NotifierContract;
use Coreplex\Notifier\Contracts\Notification as NotificationInterface;

class Notification extends AbstractNotification implements NotificationInterface {

    public function __construct(array $attributes, NotifierContract $notifier)
    {
        if ( ! empty($attributes['level'])) {
            $attributes['growlLevel'] = $this->getGrowlLevel($attributes['level']);
        }

        parent::__construct($attributes, $notifier);
    }

    /**
     * Render the notification into a JavaScript function.
     *
     * @return string
     */
    public function render()
    {
        $renderer = $this->notifier->getRenderer();
        $config = $this->notifier->getConfig();

        return $renderer->setTemplate($config['views']['growl']['notification'])
                        ->render(['notification' => $this]);
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