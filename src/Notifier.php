<?php

namespace Coreplex\Notifier;

use Coreplex\Core\Contracts\Session;
use Coreplex\Notifier\Contracts\Notifier as NotifierContract;
use Coreplex\Notifier\Contracts\TemplateParser;
use Coreplex\Notifier\Exceptions\LevelNotSetException;
use Coreplex\Notifier\Exceptions\NoDefaultNotifierSetException;
use Coreplex\Notifier\Exceptions\NotifierNotSetException;

class Notifier implements NotifierContract
{
    /**
     * The class to pass the notifier template.
     *
     * @var TemplateParser
     */
    protected $parser;

    /**
     * The session handler.
     *
     * @var Session
     */
    protected $session;

    /**
     * The package config
     *
     * @var array
     */
    protected $config;

    /**
     * The notifications for the request.
     *
     * @var array
     */
    protected $notifications = [];

    /**
     * The config of the current driver.
     *
     * @var array
     */
    protected $driver;

    public function __construct(TemplateParser $parser, Session $session, array $config)
    {
        $this->parser = $parser;
        $this->session = $session;
        $this->config = $config;

        $this->driver($this->getDefault());
    }

    /**
     * Add a new notification.
     *
     * @param string $level
     * @param array  $attributes
     * @return $this
     * @throws LevelNotSetException
     */
    public function notify($level, array $attributes = [])
    {
        if (isset($this->driver['levels'][$level])) {
            $this->notifications[] = array_merge(['level' => $this->driver['levels'][$level], 'driver' => $this->driver], $attributes);
            $this->session->flash('notifications', $this->notifications);

            return $this;
        }

        throw new LevelNotSetException("The {$level} notification level has not been set for the current driver.");
    }

    /**
     * Set a new info level notification.
     *
     * @param array $attributes
     * @return Notifier
     */
    public function info(array $attributes = [])
    {
        return $this->notify('info', $attributes);
    }

    /**
     * Set a new error level notification.
     *
     * @param array $attributes
     * @return Notifier
     */
    public function error(array $attributes = [])
    {
        return $this->notify('error', $attributes);
    }

    /**
     * Set a new success level notification.
     *
     * @param array $attributes
     * @return Notifier
     */
    public function success(array $attributes = [])
    {
        return $this->notify('success', $attributes);
    }

    /**
     * Render the notifications to javascript.
     *
     * @return string
     */
    public function render()
    {
        if ($notifications = $this->session->get('notifications')) {
            foreach ($notifications as $key => $notification) {
                $driver = array_pull($notification, 'driver');
                $notifications[$key] = $this->parser->parse($driver['template'], $notification);
            }

            if ( ! empty($notifications)) {
                return sprintf('<%s>' . implode('', $notifications) . '</%s>', 'script', 'script');
            }
        }

        return '';
    }

    /**
     * Render the notifier scripts.
     *
     * @return string
     */
    public function scripts()
    {
        $scripts = [];

        foreach ($this->driver['scripts'] as $script) {
            $scripts[] = sprintf('<script src="%s"></script>', $script);
        }

        return implode('', $scripts);
    }

    /**
     * Render the notifier styles.
     *
     * @return string
     */
    public function styles()
    {
        $styles = [];

        foreach ($this->driver['css'] as $style) {
            $styles[] = sprintf('<link rel="stylesheet" href="%s">', $style);
        }

        return implode('', $styles);
    }

    /**
     * Set the notification driver.
     *
     * @param string $driver
     * @return $this
     * @throws NotifierNotSetException
     */
    public function driver($driver)
    {
        if (isset($this->config['notifiers'][$driver])) {
            $this->driver = $this->config['notifiers'][$driver];

            return $this;
        }

        throw new NotifierNotSetException("No notifier has been set with the name {$driver}");
    }

    /**
     * Get the default notifier to user.
     *
     * @return array
     * @throws NoDefaultNotifierSetException
     */
    protected function getDefault()
    {
        if (isset($this->config['default'])) {
            return $this->config['default'];
        }

        throw new NoDefaultNotifierSetException("No default notifier has been set.");
    }

    /**
     * Dynamically add a notification.
     *
     * @param string $level
     * @param array  $args
     * @return mixed
     */
    public function __call($level, $args = [])
    {
        return call_user_func_array([$this, 'notify'], array_merge([$level], $args));
    }

    /**
     * Render the notifications to a string.
     *
     * @return string
     */
    function __toString()
    {
        return $this->render();
    }
}
