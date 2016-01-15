<?php

namespace Kurt\LiveCoding\Exceptions;

class InvalidClientIdException extends \Exception 
{

	protected $message = 'Please provide a valid `id` for the client.';

}
