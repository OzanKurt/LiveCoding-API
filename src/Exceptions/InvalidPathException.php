<?php

namespace Kurt\LiveCoding\Exceptions;

class InvalidPathException extends \Exception
{
    protected $message = 'Please provide a valid `path` for the file storage.';
}
