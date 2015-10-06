<?php

namespace Coreplex\Notifier\Tests;

class ParserTest extends BaseTest
{
    public function testParseReturnsString()
    {
        $parser = $this->parser();
        $template = 'hello world';

        $this->assertInternalType('string', $parser->parse($template));
    }

    public function testParserReplacesPlaceholders()
    {
        $parser = $this->parser();
        $template = '{{ foo }} [if:baz] {{ baz }} [endif]';
        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('qux', $parsed);
    }

    public function testIfStatementsAreRemovedIfReplacementIsNotSet()
    {
        $parser = $this->parser();
        $template = '{{ foo }} [if:baz] {{ baz }} [endif]';
        $parsed = $parser->parse($template, [
            'foo' => 'bar',
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('qux', $parsed);
    }

    public function testEqualToIfStatementIsReplacedIfTrue()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz == \'qux\'] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('qux', $parsed);
    }

    public function testEqualToIfStatementIsNotReplacedIfFalse()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz == \'foo\'] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('qux', $parsed);
    }

    public function testEqualToIfDoesNotEqualStatementIsReplacedIfTrue()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz != \'foo\'] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('qux', $parsed);
    }

    public function testEqualToIfDoesNotEqualStatementIsNotReplacedIfFalse()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz != \'qux\'] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 'qux'
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('qux', $parsed);
    }

    public function testEqualToIfGreaterThanStatementIsReplacedIfTrue()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz > 0] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 1
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('1', $parsed);
    }

    public function testEqualToIfGreaterThanStatementIsNotReplacedIfFalse()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz > 5] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 2
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('2', $parsed);
    }

    public function testEqualToIfGreaterThanOrEqualStatementIsReplacedIfTrue()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz >= 1] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 1
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('1', $parsed);
    }

    public function testEqualToIfGreaterThanOrEqualStatementIsNotReplacedIfFalse()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz >= 5] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 2
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('2', $parsed);
    }

    public function testEqualToIfLessThanStatementIsReplacedIfTrue()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz < 2] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 1
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('1', $parsed);
    }

    public function testEqualToIfLessThanStatementIsNotReplacedIfFalse()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz < 1] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 2
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('2', $parsed);
    }

    public function testEqualToIfLessThanOrEqualStatementIsReplacedIfTrue()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz <= 1] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 1
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertContains('1', $parsed);
    }

    public function testEqualToIfLessThanOrEqualStatementIsNotReplacedIfFalse()
    {
        $parser = $this->parser();

        $template = '{{ foo }} [if:baz <= 1] {{ baz }} [endif]';

        $parsed = $parser->parse($template, [
            'foo' => 'bar',
            'baz' => 2
        ]);

        $this->assertContains('bar', $parsed);
        $this->assertNotContains('2', $parsed);
    }
}