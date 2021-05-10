<?php

namespace PHPeak\HTTP;

use JetBrains\PhpStorm\Pure;

class Parameter
{

	/**
	 * Parameter constructor.
	 *
	 * @param string $key
	 * @param $value
	 */
	public function __construct(
		private string $key,
		private $value
	)
	{
	}

	#[Pure]
	public function hasMultipleValues(): bool
	{
		return is_array($this->value);
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getKey()
	{
		return $this->value;
	}
}
