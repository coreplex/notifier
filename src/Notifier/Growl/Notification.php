<?php namespace Coreplex\Notifier\Growl;

use Illuminate\Support\Fluent;
use Coreplex\Notifier\Contracts\Notifier as NotifierContract;
use Coreplex\Notifier\Contracts\Notification as NotificationInterface;

class Notification extends Fluent implements NotificationInterface {

    /**
     * An instance of a coreplex notifier.
     *
     * @var Renderer
     */
    protected $notifier;

    public function __construct(array $properties, NotifierContract $notifier)
    {
        if ( ! empty($properties['level'])) {
            $properties['growlLevel'] = $this->getGrowlLevel($properties['level']);
        }

        $this->notifier = $notifier;

        parent::__construct($properties);
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