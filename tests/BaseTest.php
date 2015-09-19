<?php

namespace Coreplex\Notifier\Tests;

use Coreplex\Notifier\Notifier;
use Coreplex\Notifier\Parser;
use Coreplex\Notifier\Session\Native;
use PHPUnit_Framework_TestCase;

class BaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Get a notifier instance.
     *
     * @return Notifier
     */
    protected function notifier()
    {
        return new Notifier($this->parser(), $this->session(), $this->config());
    }

    /**
     * Get a template parser instance.
     *
     * @return Parser
     */
    protected function parser()
    {
        return new Parser();
    }

    /**
     * Get a session instance.
     *
     * @return Native
     */
    protected function session()
    {
        return new Native($this->config());
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