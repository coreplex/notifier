<?php namespace Coreplex\Notifier;

use Coreplex\Notifier\Contracts\Session;
use Illuminate\Support\Manager;
use Coreplex\Notifier\Contracts\Renderer;

class NotifierManager extends Manager {

    /**
     * An instance of a notifier session.
     *
     * @var Session
     */
    protected $session;

    /**
     * An instance of a notifier renderer.
     *
     * @var Renderer
     */
    protected $renderer;

    public function __construct($app, Session $session, Renderer $renderer)
    {
        parent::__construct($app);

        $this->renderer = $renderer;
        $this->session = $session;
    }

    /**
     * Create the alertify notification driver.
     * 
     * @return Alertify\Notifier
     */
    public function createAlertifyDriver()
    {
        return new Alertify\Notifier($this->session, $this->renderer, config('notifier'));
    }

    /**
     * Create the growl notification driver.
     *
     * @return Growl\Notifier
     */
    public function createGrowlDriver()
    {
        return new Growl\Notifier($this->session, $this->renderer, config('notifier'));
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