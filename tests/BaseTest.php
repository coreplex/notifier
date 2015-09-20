<?php

namespace Coreplex\Notifier\Tests;

use Coreplex\Notifier\Notifier;
use Coreplex\Notifier\Parser;
use Coreplex\Core\Session\Native;
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
        return new Native($this->coreConfig());
    }

    /**
     * Get the package config.
     *
     * @return array
     */
    protected function config()
    {
        return require __DIR__ . '/../config/notifier.php';
    }

    /**
     * Get the package config.
     *
     * @return array
     */
    protected function coreConfig()
    {
        return require __DIR__ . '/../vendor/coreplex/core/config/coreplex.php';
    }

    public function testCommon()
    {
        //
    }
}