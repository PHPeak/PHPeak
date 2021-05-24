<?php

namespace PHPeak\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class InvalidKeyException extends Exception
{
	#[Pure]
	public function __construct(string $key)
	{
		$message = sprintf('Key %s not found', $key);

		parent::__construct($message);
	}

}
