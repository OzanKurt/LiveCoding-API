<?php

namespace Kurt\LiveCoding\Exceptions;

/**
 * Class InvalidScopeException
 * @package Kurt\LiveCoding\Exceptions
 */
class InvalidScopeException extends \Exception
{
    protected $message = 'Please provide a valid `scope` for the client.';
}
