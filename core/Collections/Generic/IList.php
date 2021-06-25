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

	/**
	 * Find the index of an element by its value
	 *
	 * @param mixed $value The value to search for
	 * @return int The index of the element if found, otherwise -1
	 */
	public function indexOf(mixed $value): int;
}
