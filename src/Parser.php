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
            $check = $this->check($if[1], $replacements);

            $body = str_replace($if[0], $check ? $if[2] : "", $body);
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

    /**
     * Check if the provided expression is true.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function check($expression, array $data)
    {
        if (strpos($expression, '==') !== false) {
            return $this->checkEquals($expression, $data);
        }

        if (strpos($expression, '!=') !== false) {
            return $this->checkDoesNotEqual($expression, $data);
        }

        if (strpos($expression, '>=') !== false) {
            return $this->checkGreaterThanOrEqual($expression, $data);
        }

        if (strpos($expression, '>') !== false) {
            return $this->checkGreaterThan($expression, $data);
        }

        if (strpos($expression, '<=') !== false) {
            return $this->checkLessThanOrEqual($expression, $data);
        }

        if (strpos($expression, '<') !== false) {
            return $this->checkLessThan($expression, $data);
        }

        return isset($expression);
    }

    /**
     * Run the equals if statement.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function checkEquals($expression, array $data)
    {
        $args = explode('==', $expression);
        list($key, $value) = $this->cleanKeyValue($args);

        return isset($data[$key]) ? ($data[$key] == $value) : false;
    }

    /**
     * Run the does not equal statement.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function checkDoesNotEqual($expression, array $data)
    {
        $args = explode('!=', $expression);
        list($key, $value) = $this->cleanKeyValue($args);

        return isset($data[$key]) ? ($data[$key] != $value) : false;
    }

    /**
     * Run the greater than statement.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function checkGreaterThan($expression, array $data)
    {
        $args = explode('>', $expression);
        list($key, $value) = $this->cleanKeyValue($args);

        return isset($data[$key]) ? ($data[$key] > $value) : false;
    }

    /**
     * Run the greater than or equal to statement.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function checkGreaterThanOrEqual($expression, array $data)
    {
        $args = explode('>=', $expression);
        list($key, $value) = $this->cleanKeyValue($args);

        return isset($data[$key]) ? ($data[$key] >= $value) : false;
    }

    /**
     * Run the less than statement.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function checkLessThan($expression, array $data)
    {
        $args = explode('<', $expression);
        list($key, $value) = $this->cleanKeyValue($args);

        return isset($data[$key]) ? ($data[$key] < $value) : false;
    }

    /**
     * Run the less than or equal to statement.
     *
     * @param string $expression
     * @param array  $data
     * @return bool
     */
    protected function checkLessThanOrEqual($expression, array $data)
    {
        $args = explode('<=', $expression);
        list($key, $value) = $this->cleanKeyValue($args);

        return isset($data[$key]) ? ($data[$key] <= $value) : false;
    }

    /**
     * Get the key value pair from the provided array.
     *
     * @param array $args
     * @return array
     */
    protected function cleanKeyValue($args)
    {
        $key = trim($args[0]);
        $value = str_replace(['\'', '"'], '', trim($args[1]));
        return array($key, $value);
    }
}