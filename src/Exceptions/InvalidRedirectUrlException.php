<?php

namespace Kurt\LiveCoding\Exceptions;

/**
 * Class InvalidRedirectUrlException
 * @package Kurt\LiveCoding\Exceptions
 */
class InvalidRedirectUrlException extends \Exception
{
    protected $message = 'Please provide a valid `redirectUrl` for the client.';
}
