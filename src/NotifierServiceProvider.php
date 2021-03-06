<?php

namespace Coreplex\Notifier;

use Coreplex\Core\Session\Illuminate;
use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the config files.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/notifier.php' => config_path('notifier.php')
        ]);

        $this->mergeConfigFrom(__DIR__.'/../config/notifier.php', 'notifier');
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerParser();
        $this->registerNotifier();
    }

    /**
     * Register the notification template parser.
     */
    protected function registerParser()
    {
        $this->app->bind('Coreplex\Notifier\Contracts\TemplateParser', function() {
            return new Parser();
        });
    }

    /**
     * Register the notifier.
     */
    protected function registerNotifier()
    {
        $this->app->singleton('Coreplex\Notifier\Contracts\Notifier', function($app) {
            return new Notifier(
                $app['Coreplex\Notifier\Contracts\TemplateParser'],
                $app['Coreplex\Core\Contracts\Session'],
                config('notifier')
            );
        });

        $this->app->alias('Coreplex\Notifier\Contracts\Notifier', 'coreplex.notifier');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Coreplex\Notifier\Contracts\TemplateParser',
            'Coreplex\Notifier\Contracts\Notifier',
            'coreplex.notifier',
        ];
    }
}