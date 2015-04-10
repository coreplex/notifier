<?php namespace Coreplex\Notifier\Alertify;

use Illuminate\Support\Fluent;
use Coreplex\Notifier\Contracts\Notifier as NotifierContract;
use Coreplex\Notifier\Contracts\Notification as NotificationInterface;

class Notification extends Fluent implements NotificationInterface {

    /**
     * An instance of a notifier.
     *
     * @var NotifierContract
     */
    protected $notifier;

    public function __construct(array $properties, NotifierContract $notifier)
    {
        $properties['alertifyLevel'] = $this->getAlertifyLevel($properties['level']);

        parent::__construct($properties);

        $this->notifier = $notifier;
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