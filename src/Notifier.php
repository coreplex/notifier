<?php

namespace Coreplex\Notifier;

use Coreplex\Notifier\Contracts\Notifier as NotifierContract;
use Coreplex\Notifier\Contracts\Session;
use Coreplex\Notifier\Contracts\TemplateParser;

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
        $this->config = $config;

        $this->driver($this->getDefault());
        $this->session = $session;
    }

    /**
     * Add a new notification.
     *
     * @param string $level
     * @param array  $attributes
     * @return $this
     */
    public function notify($level, array $attributes = [])
    {
        $this->notifications[] = array_merge(['level' => $this->driver['levels'][$level]], $attributes);
        $this->session->flash($this->config['sessionKey'], $this->notifications);

        return $this;
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
        return $this->notify('info', $attributes);
    }

    /**
     * Set a new success level notification.
     *
     * @param array $attributes
     * @return Notifier
     */
    public function success(array $attributes = [])
    {
        return $this->notify('info', $attributes);
    }

    /**
     * Render the notifications to javascript.
     *
     * @return string
     */
    public function render()
    {
        $notifications = [];

        foreach ($this->session->get($this->config['sessionKey']) as $notification) {
            $notifications[] = $this->parser->parse($this->driver['template'], $notification);
        }

        if ( ! empty($notifications)) {
            return sprintf('<%s>' . implode('', $notifications) . '</%s>', 'script', 'script');
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
     */
    public function driver($driver)
    {
        $this->driver = $this->config['notifiers'][$driver];

        return $this;
    }

    /**
     * Get the default notifier to user.
     *
     * @return array
     */
    protected function getDefault()
    {
        return $this->config['default'];
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
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString()
    {
        return $this->render();
    }
}