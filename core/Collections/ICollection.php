<?php

namespace PHPeak\Collections;

interface ICollection
{

	/**
	 * Remove the element with the given key
	 *
	 * @param $key
	 */
	public function remove(mixed $key): void;

	/**
	 * Remove an element at the given index
	 *
	 * @param int $index
	 */
	public function removeAt(int $index): void;

	/**
	 * Get the element at the given index
	 *
	 * @param int $index
	 * @return mixed The value at the index or null
	 */
	public function getAt(int $index): mixed;

	/**
	 * Checks whether the given key exists
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function keyExists(mixed $key): bool;

	/**
	 * Checks whether the given value exists
	 * NOTE: If an object is given to compare, the given value has to point to the same object instance
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public function contains(mixed $value): bool;

	public function sort(callable $fn = null): self;

	public function find(callable $fn = null): mixed;

	public function findAll(callable $fn = null): mixed;

	public function copy(): self;

	//TODO findAll (callback)
	//TODO copy
}
