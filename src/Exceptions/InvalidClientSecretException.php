<?php

namespace Kurt\LiveCoding\Exceptions;

class InvalidClientSecretException extends \Exception 
{

	protected $message = 'Please provide a valid `secret` for the client.';

}
