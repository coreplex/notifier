<?php namespace Coreplex\Notifier\Tests; 

use Coreplex\Notifier\Session\Native;
use PHPUnit_Framework_TestCase;

class NativeSessionTest extends PHPUnit_Framework_TestCase {

    public function __construct () {
        // Fixes error with session_start() and phpunit
        ob_start();
    }

    public function testSessionHasValue()
    {
        $session = $this->newSession();
        $session->put('foo', 'bar');

        $this->assertEquals(true, $session->has('foo'));
    }

    public function testValueCanBeRetrievedFromSession()
    {
        $session = $this->newSession();
        $session->put('foo', 'bar');

        $this->assertEquals('bar', $session->get('foo'));
    }

    public function testValueCanBeStoredInSession()
    {
        $session = $this->newSession();
        $session->put('foo', 'bar');

        $this->assertEquals(true, $session->has('foo'));
    }

    public function testValueCanBeRemovedFromSession()
    {
        $session = $this->newSession();
        $session->put('foo', 'bar');
        $session->forget('foo');

        $this->assertEquals(false, $session->has('foo'));
    }

    public function testValueCanBeFlashedToSession()
    {
        $session = $this->newSession();
        $session->flash('foo', 'bar');

        $this->assertEquals(true, $session->has('flash'));
    }

    protected function newSession()
    {
        $config = $this->getConfig();

        return new Native($config);
    }

    protected function getConfig()
    {
        return require  __DIR__ . '/../config/notifier.php';
    }

}