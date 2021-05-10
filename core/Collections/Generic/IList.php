<?php

namespace PHPeak\Collections\Generic;

use PHPeak\Collections\ICollection;

interface IList extends ICollection
{
	public function __construct(string $valueType);

	/**
	 * Add an element with the given value
	 *
	 * @param mixed $value
	 * @return int The index of the newly added element
	 */
	public function add(mixed $value): int;
}
