<?php

namespace Kurt\LiveCoding\Exceptions;

/**
 * Class InvalidClientSecretException
 * @package Kurt\LiveCoding\Exceptions
 */
class InvalidClientSecretException extends \Exception
{
    protected $message = 'Please provide a valid `secret` for the client.';
}
