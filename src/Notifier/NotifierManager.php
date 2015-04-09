<?php namespace Coreplex\Notifier;

use Illuminate\Support\Manager;

class NotifierManager extends Manager {

    /**
     * Create the alertify notification driver.
     * 
     * @return Alertify\Notifier
     */
    public function createAlertifyDriver()
    {
        return new Alertify\Notifier($this->app['session.store'], config('notifier'));
    }

    /**
     * Create the growl notification driver.
     *
     * @return Growl\Notifier
     */
    public function createGrowlDriver()
    {
        return new Growl\Notifier($this->app['session.store'], config('notifier'));
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