<?php namespace Coreplex\Notifier;

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
        $this->loadViewsFrom(__DIR__.'/../public/views/', 'notifier');
        // Set the folders to publish
        $this->publishes([
            __DIR__.'/../config/notifier.php' => config_path('notifier.php'),
            __DIR__.'/../public/views/' => public_path('resources/views/'),
        ]);
        // Merge the original config with the applications version.
        $this->mergeConfigFrom(__DIR__.'/../config/notifier.php', 'notifier');
    }

    /**
     * Register the notifier.
     */
    public function register()
    {
        $this->app->singleton('coreplex.notifier', function($app)
        {
            return new NotifierManager($app);
        });

        $this->app->bind('coreplex.notifier.driver', function($app)
        {
            return $app['coreplex.notifier']->driver();
        });

        $this->app->bind('Coreplex\Notifier\Contracts\Notifier', function($app)
        {
            return $app['coreplex.notifier.driver'];
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