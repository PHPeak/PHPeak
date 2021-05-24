<?php

namespace PHPeak\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class DuplicateKeyException extends Exception
{

	/**
	 * DuplicateKeyException constructor.
	 *
	 * @param mixed $key
	 */
	#[Pure]
	public function __construct(string $key)
	{
		$message = sprintf("Key '%s' is already in use", $key);
		parent::__construct($message);
	}
}
