<?php

namespace Coreplex\Notifier\Tests;

use Coreplex\Notifier\Session\Native;

class NativeSessionTest extends BaseTest
{
    public function setUp()
    {
        // Fixes issues with session_start and phpunit
        @session_start();
    }

    public function testSessionHasValue()
    {
        $session = $this->session();
        $session->put('foo', 'bar');

        $this->assertEquals(true, $session->has('foo'));
    }

    public function testValueCanBeRetrievedFromSession()
    {
        $session = $this->session();
        $session->put('foo', 'bar');

        $this->assertEquals('bar', $session->get('foo'));
    }

    public function testValueCanBeStoredInSession()
    {
        $session = $this->session();
        $session->put('foo', 'bar');

        $this->assertEquals(true, $session->has('foo'));
    }

    public function testValueCanBeRemovedFromSession()
    {
        $session = $this->session();
        $session->put('foo', 'bar');
        $session->forget('foo');

        $this->assertEquals(false, $session->has('foo'));
    }

    public function testValueCanBeFlashedToSession()
    {
        $session = $this->session();
        $session->flash('foo', 'bar');

        $this->assertEquals(true, $session->has('flash'));
    }
}