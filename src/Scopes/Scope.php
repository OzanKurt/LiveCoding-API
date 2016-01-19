<?php

namespace Kurt\LiveCoding\Scopes;

/**
 * Class Scope
 * @package Kurt\LiveCoding\Scopes
 */
abstract class Scope
{
    /**
     * String representations of the scope.
     *
     * @var string
     */
    protected $text;

    /**
     * Get the string representations of the scope.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
