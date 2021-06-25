<?php

namespace PHPeak\Exceptions;

use Exception;
use Throwable;

class DuplicateKeyException extends Exception
{

	public function __construct($key = '')
	{
		$message = sprintf("Key '%s' is already in use", $key);

		parent::__construct($message);
	}

}
