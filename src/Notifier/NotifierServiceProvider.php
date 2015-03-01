<?php namespace Michaeljennings\Notifier;

use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider {

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Load any files and configuration required for the notifier when the
     * package is initialised.
     */
    public function boot()
    {
        // Set the directory to load views from
        $this->loadViewsFrom(__DIR__.'/publish/resources/views/', 'notifier');
        // Set the folders to publish
        $this->publishes([__DIR__.'/publish/' => base_path()]);
        // Merge the original config with the applications version.
        $this->mergeConfigFrom(__DIR__.'/publish/config/notifier.php', 'notifier');
    }

    /**
     * Register the notifier.
     */
    public function register()
    {
        $this->app->singleton('michaeljennings.notifier', function($app)
        {
            return new NotifierManager($app);
        });

        $this->app->bind('michaeljennings.notifier.driver', function($app)
        {
            return $app['michaeljennings.notifier']->driver();
        });

        $this->app->bind('Michaeljennings\Notifier\Contracts\Notifier', function($app)
        {
            return $app['michaeljennings.notifier.driver'];
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['Notifier'];
    }

}