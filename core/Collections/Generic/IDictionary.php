<?php

namespace PHPeak\Collections\Generic;

use PHPeak\Collections\ICollection;

interface IDictionary extends ICollection
{
	public function __construct(string $keyType, string $valueType);

	/**
	 * Add an element with the given key and value
	 *
	 * @param mixed $key
	 * @param mixed $value
	 * @return int The index of the newly added element
	 */
	public function add(mixed $key, mixed $value): int;

}
