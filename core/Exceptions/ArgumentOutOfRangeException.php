<?php

namespace PHPeak\Exceptions;

use Exception;

class ArgumentOutOfRangeException extends Exception
{

	public function __construct(int $index)
	{
		$message = sprintf('Index %d is out of range', $index);

		parent::__construct($message);
	}

}
