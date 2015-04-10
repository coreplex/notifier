<?php namespace Coreplex\Notifier;

use Illuminate\Support\Manager;
use Coreplex\Notifier\Contracts\Renderer;

class NotifierManager extends Manager {

    /**
     * An instance of a notifier renderer.
     *
     * @var Renderer
     */
    protected $renderer;

    public function __construct($app, Renderer $renderer)
    {
        parent::__construct($app);

        $this->renderer = $renderer;
    }

    /**
     * Create the alertify notification driver.
     * 
     * @return Alertify\Notifier
     */
    public function createAlertifyDriver()
    {
        return new Alertify\Notifier(
            $this->app['session.store'],
            $this->renderer,
            config('notifier')
        );
    }

    /**
     * Create the growl notification driver.
     *
     * @return Growl\Notifier
     */
    public function createGrowlDriver()
    {
        return new Growl\Notifier(
            $this->app['session.store'],
            $this->renderer,
            config('notifier')
        );
    }

    /**
     * Return the defualt driver to be used by the notifier.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return config('notifier.driver');
    }

}