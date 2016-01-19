<?php

namespace Kurt\LiveCoding\Exceptions;

/**
 * Class InvalidStorageException
 * @package Kurt\LiveCoding\Exceptions
 */
class InvalidStorageException extends \Exception
{
    protected $message = 'Please provide a valid `storage` for the client.';
}
