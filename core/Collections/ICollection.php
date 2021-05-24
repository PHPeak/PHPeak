<?php

namespace PHPeak\Collections;

use PHPeak\Exceptions\ArgumentOutOfRangeException;
use PHPeak\Exceptions\InvalidKeyException;

interface ICollection
{

	/**
	 * Convert an array into an collection
	 *
	 * @param array $array
	 */
	public static function fromArray(array $array): void;

	/**
	 * Convert the collection into an array
	 *
	 * @return array
	 */
	public function toArray(): array;

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
	 * Get the element with the given key
	 *
	 * @param mixed $key
	 * @throws InvalidKeyException When the key was not found
	 * @return mixed The value for the key
	 */
	public function get(mixed $key): mixed;

	/**
	 * Get the element with the given key and return it to the $result reference
	 *
	 * @param mixed $key
	 * @param mixed &$result
	 * @return bool Whether a result was found or not
	 */
	public function tryGet(mixed $key, mixed &$result): bool;

	/**
	 * Get the element at the given index
	 *
	 * @param int $index
	 * @throws ArgumentOutOfRangeException When the given index is out of range
	 * @return mixed The value at the index
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

	/**
	 * Return the index of the key
	 *
	 * @param mixed $key
	 * @return int
	 */
	public function indexOf(mixed $key): int;

	/**
	 * Iterate over each item in the collection
	 *
	 * @param callable $callback([$value], [$key], [$index]) Called on each item
	 */
	public function forEach(callable $callback): void;

	//length/count
}
