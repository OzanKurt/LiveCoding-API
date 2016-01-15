<?php

namespace Kurt\LiveCoding\Scopes;

abstract class Scope
{

	protected $text;

	public function getText()
	{
		return $this->text;
	}

}
