<?php namespace Michaeljennings\Notifier;

use Illuminate\Session\Store;
use Michaeljennings\Notifier\Contracts\Notifier as NotifierInterface;

abstract class AbstractNotifier implements NotifierInterface {

    /**
     * The view we shall use to render notifications.
     *
     * @var mixed
     */
    protected $template;

    /**
     * An array of notifications to be displayed.
     *
     * @var array
     */
    protected $notifications = [
        'success' => [],
        'info' => [],
        'warning' => [],
        'error' => [],
    ];

    /**
     * An instance of the illuminate session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * The notifier config.
     *
     * @var array
     */
    protected $config;

    public function __construct(Store $session, array $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * Set the template being used for the notifier.
     *
     * @return \Illuminate\View\View
     */
    abstract public function setTemplate();

    /**
     * Return an array of scripts to be included on the frontend.
     *
     * @return array
     */
    abstract protected function getScripts();

    /**
     * Return an array of styles to be inculded on the frontend.
     *
     * @return array
     */
    abstract protected function getStyles();

    /**
     * Get the notification class for the notifier.
     *
     * @param array $properties
     * @return \Nexus\Contracts\Notifier\Notification
     */
    abstract protected function newNotification(array $properties);

    /**
     * Add a new notification into the notifications array and then flash the
     * notifications to the session.
     *
     * @param array $data
     * @param $level
     */
    public function notify(array $data = [], $level)
    {
        $this->notifications[$level][] = $this->newNotification(['level' => $level] + $data)->render();

        $this->session->flash($this->getSessionKey(), $this->notifications);
    }

    /**
     * Add a success notification.
     *
     * @param array $data
     */
    public function success(array $data = [])
    {
        return $this->notify($data, 'success');
    }

    /**
     * Add an info notification.
     *
     * @param array $data
     */
    public function info(array $data = [])
    {
        return $this->notify($data, 'info');
    }

    /**
     * Add a warning notification.
     *
     * @param array $data
     */
    public function warning(array $data = [])
    {
        return $this->notify($data, 'warning');
    }

    /**
     * Add an error notification.
     *
     * @param array $data
     */
    public function error(array $data = [])
    {
        return $this->notify($data, 'error');
    }

    /**
     * Check if any notifications exist in the session, if so retrieve them. An
     * optional notification level can be passed to only retrieve notifications
     * of a certain level.
     *
     * @param string|bool $level
     * @return array|mixed
     */
    public function getNotifications($level = false)
    {
        $sessionKey = $this->getSessionKey($level);

        if ($this->session->has($sessionKey)) {
            return $this->session->get($sessionKey);
        }

        return [];
    }

    /**
     * Render the notifications view to be used on the frontend.
     *
     * @return \Illuminate\View\View
     */
    public function renderNotifications()
    {
        return $this->setTemplate()->with('notifier', $this);
    }
    /**
     * @return string
     */
    public function renderScripts()
    {
        $scripts = '';

        foreach ($this->getScripts() as $script) {
            $scripts .= '<script type="text/javascript" src="' . asset($script) . '"></script>';
        }

        return $scripts;
    }

    /**
     * @return string
     */
    public function renderStyles()
    {
        $styles = '';

        foreach ($this->getStyles() as $style) {
            $styles .= '<link rel="stylesheet" type="text/css" href="' . asset($style) . '">';
        }

        return $styles;
    }

    /**
     * @param bool $level
     * @return string
     */
    protected function getSessionKey($level = false)
    {
        return $this->config['sessionPrefix'] . '.notifications' . $level ? '.' . $level : '';
    }

}