<?php

namespace Kurt\LiveCoding\Exceptions;

class InvalidStorageException extends \Exception
{
    protected $message = 'Please provide a valid `storage` for the client.';
}
