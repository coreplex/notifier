<?php

namespace Coreplex\Notifier\Tests;

class NotifierTest extends BaseTest
{
    public function testNotifierImplementsContract()
    {
        $notifier = $this->notifier();

        $this->assertInstanceOf('Coreplex\\Notifier\\Contracts\\Notifier', $notifier);
    }

    public function testNotifyMethodReturnsNotifier()
    {
        $notifier = $this->notifier();

        $this->assertInstanceOf('Coreplex\\Notifier\\Contracts\\Notifier', $notifier->notify('info'));
    }

    public function testNotificationLevelCanBeCalledDynamically()
    {
        $notifier = $this->notifier();

        $this->assertInstanceOf('Coreplex\\Notifier\\Contracts\\Notifier', $notifier->info());
    }

    public function testCallingNonExistantNotificationLevelThrowsException()
    {
        $this->setExpectedException('Coreplex\\Notifier\\Exceptions\\LevelNotSetException');

        $notifier = $this->notifier();

        $notifier->notify('fooBar');
    }

    public function testRenderDoesNotFailIfNoNotificationsHaveBeenSet()
    {
        $notifier = $this->notifier();

        $this->assertEquals('', $notifier->render());
    }

    public function testRenderingNotificationsWithoutDynamicData()
    {
        $notifier = $this->notifier()->notify('info');

        $this->assertInternalType('string', $notifier->render());
    }

    public function testRenderWrapsNotificationsInScriptTags()
    {
        $notifier = $this->notifier()->notify('info');

        $this->assertContains('script', $notifier->render());
    }

    public function testDynamicDataGetsAddedToTemplate()
    {
        $notifier = $this->notifier()->notify('info', ['title' => 'foo']);

        $this->assertContains('foo', $notifier->render());
    }

    public function testDriverReturnsTheNotifier()
    {
        $notifier = $this->notifier();

        $this->assertInstanceOf('Coreplex\\Notifier\\Contracts\\Notifier', $notifier->driver('alertify'));
    }

    public function testExceptionIsThrownWhenAccessingUnRegisteredNotifier()
    {
        $this->setExpectedException('Coreplex\\Notifier\\Exceptions\\NotifierNotSetException');

        $notifier = $this->notifier();

        $notifier->driver('fooBar');
    }

    public function testStylesReturnsString()
    {
        $notifier = $this->notifier();

        $this->assertInternalType('string', $notifier->styles());
    }

    public function testScriptsReturnsString()
    {
        $notifier = $this->notifier();

        $this->assertInternalType('string', $notifier->scripts());
    }
}