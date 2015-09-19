<?php

namespace Coreplex\Notifier\Tests;

use Coreplex\Notifier\Notifier;
use Coreplex\Notifier\Parser;
use Coreplex\Notifier\Session\Native;
use PHPUnit_Framework_TestCase;

class BaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Native
     */
    protected $session;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * Get a notifier instance.
     *
     * @return Notifier
     */
    protected function notifier()
    {
        if ( ! isset($this->notifier)) {
            $this->notifier = new Notifier($this->parser(), $this-session(), $this->config());
        }

        return $this->notifier;
    }

    /**
     * Get a template parser instance.
     *
     * @return Parser
     */
    protected function parser()
    {
        if ( ! isset($this->parser)) {
            $this->parser = new Parser();
        }

        return $this->parser;
    }

    /**
     * Get a session instance.
     *
     * @return Native
     */
    protected function session()
    {
        if ( ! isset($this->session)) {
            $this->session = new Native($this->config());
        }

        return $this->session;
    }

    /**
     * Get the package config.
     *
     * @return array
     */
    protected function config()
    {
        if ( ! isset($this->config)) {
            $this->config = require __DIR__ . '/../config/notifier.php';
        }

        return $this->config;
    }

    public function testCommon()
    {
        //
    }
}