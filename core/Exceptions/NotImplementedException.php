<?php

namespace PHPeak\Exceptions;

use Exception;

class NotImplementedException extends Exception
{
	public function __construct()
	{
		$method = $this->getTrace()[0]['function'] ?? '';
		$class = $this->getTrace()[0]['class'] ?? '';

		$message = sprintf("Method '%s::%s' is not yet implemented", $class, $method);

		parent::__construct($message);
	}

}
