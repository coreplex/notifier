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
}