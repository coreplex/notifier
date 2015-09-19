<?php

namespace Coreplex\Notifier;

use Coreplex\Notifier\Contracts\TemplateParser;

class Parser implements TemplateParser
{
    /**
     * Parse the template body.
     *
     * @param string $body
     * @param array  $replacements
     * @return mixed
     */
    public function parse($body, $replacements = [])
    {
        $body = $this->parseIfs($body, $replacements);

        return $this->replacePlaceholders($body, $replacements);
    }

    /**
     * Replace the placeholders in the body template with the replacements
     * array.
     *
     * @param string $body
     * @param array  $replacements
     * @return mixed
     */
    protected function replacePlaceholders($body, $replacements)
    {
        if (preg_match_all('/{{(.*?)}}/', $body, $matches)) {
            foreach ($matches[0] as $key => $placeholder) {
                $key = trim($matches[1][$key]);

                $body = str_replace($placeholder, isset($replacements[$key]) ? $replacements[$key] : '', $body);
            }
        }

        return $body;
    }

    /**
     * Parse any if statements in the template body.
     *
     * @param string $body
     * @param array  $replacements
     * @return mixed
     */
    protected function parseIfs($body, array $replacements)
    {
        foreach ($this->getIfs($body) as $if) {
            $body = str_replace($if[0], ! isset($replacements[$if[1]]) ? "" : $if[2], $body);
        }

        return $body;
    }

    /**
     * Find any if statements in the template.
     *
     * @param string $body
     * @param array  $matches
     * @return array|mixed
     */
    protected function getIfs($body, $matches = [])
    {
        if ($match = $this->checkForIf($body)) {
            $matches[] = $match;
            $body = str_replace($match[0], '', $body);

            $matches = $this->getIfs($body, $matches);
        }

        return $matches;
    }

    /**
     * Check for any if statements in the string.
     *
     * @param string $body
     * @return bool
     */
    protected function checkForIf($body)
    {
        if (preg_match('/\[if:(.*?)\](.*?)\[endif\]/', $body, $matches)) {
            return $matches;
        }

        return false;
    }
}