<?php

namespace Coreplex\Notifier\Contracts;

interface TemplateParser
{
    /**
     * Parse the template body.
     *
     * @param string $body
     * @param array  $replacements
     * @return mixed
     */
    public function parse($body, $replacements = []);
}