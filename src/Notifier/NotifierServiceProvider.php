<?php namespace Coreplex\Notifier;

use ReflectionClass;
use Illuminate\Support\ServiceProvider;
use Coreplex\Notifier\Session\IlluminateSession;

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
        $this->loadViewsFrom(__DIR__.'/../../views/', 'notifier');
        // Set the folders to publish
        $this->publishes([
            __DIR__ . '/../../config/notifier.php' => config_path('notifier.php')
        ]);
        // Merge the original config with the applications version.
        $this->mergeConfigFrom(__DIR__.'/../../config/notifier.php', 'notifier');
    }

    /**
     * Register the notifier.
     */
    public function register()
    {
        $this->registerSession();
        $this->registerRenderer();

        $this->app->singleton('coreplex.notifier', function($app)
        {
            return new NotifierManager(
                $app,
                $app->make('Coreplex\Notifier\Contracts\Session'),
                $app->make('Coreplex\Notifier\Contracts\Renderer')
            );
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
     * Register the notifier session.
     */
    protected function registerSession()
    {
        $this->app->singleton('Coreplex\Notifier\Contracts\Session', function($app)
        {
            return (new ReflectionClass(config('notifier.session')))->newInstanceArgs([$app['session.store']]);
        });
    }

    /**
     * Register the notifier renderer.
     */
    protected function registerRenderer()
    {
        $this->app->bind('Coreplex\Notifier\Contracts\Renderer', function($app)
        {
            return (new ReflectionClass(config('notifier.renderer')))->newInstanceArgs([$app['view']]);
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