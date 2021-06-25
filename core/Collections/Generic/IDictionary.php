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

  /**
   * Get the element with the given key
   *
   * @param mixed $key
   * @return mixed The value at the index or null
   */
  public function get(mixed $key): mixed;

	/**
	 * Find the index of an element by its key
	 *
	 * @param mixed $key The key to search for
	 * @return int The index of the element if found, otherwise -1
	 */
  public function indexOf(mixed $key): int;

}
