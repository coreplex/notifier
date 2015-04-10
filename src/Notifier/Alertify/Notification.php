<?php namespace Coreplex\Notifier\Alertify;

use Coreplex\Notifier\AbstractNotification;
use Coreplex\Notifier\Contracts\Notifier as NotifierContract;
use Coreplex\Notifier\Contracts\Notification as NotificationInterface;

class Notification extends AbstractNotification implements NotificationInterface {

    /**
     * An instance of a notifier.
     *
     * @var NotifierContract
     */
    protected $notifier;

    public function __construct(array $attributes, NotifierContract $notifier)
    {
        $attributes['alertifyLevel'] = $this->getAlertifyLevel($attributes['level']);

        parent::__construct($attributes, $notifier);
    }

    /**
     * Render the notification into a JavaScript function.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $renderer = $this->notifier->getRenderer();
        $config = $this->notifier->getConfig();

        return $renderer->setTemplate($config['views']['alertify']['notification'])
            ->render(['notification' => $this]);
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