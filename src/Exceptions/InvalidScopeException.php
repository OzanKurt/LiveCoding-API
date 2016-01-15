<?php

namespace Kurt\LiveCoding\Exceptions;

class InvalidScopeException extends \Exception 
{

	protected $message = 'Please provide a valid `scope` for the client.';

}
