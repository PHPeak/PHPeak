<?php

namespace PHPeak\Collections;

use PHPeak\Callable\IBooleanCallable;
use PHPeak\Sorting\Comparator\IComparator;

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
	 * Get the value at the specified index or null
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
	 * NOTE: If an object is given to look for, the given value has to point to the same object instance
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public function contains(mixed $value): bool;

	/**
	 * Sort the items in the current Collection
	 *
	 * @param IComparator|null $comparator If no comparator is supplied, the items will be sorted ascending based on their value
	 * @return $this
	 */
	public function sort(?IComparator $comparator = null): self;

	/**
	 * Finds the first item that matches the expression supplied in the callback
	 *
	 * @param IBooleanCallable $callback
	 * @return mixed
	 */
	public function find(IBooleanCallable $callback): mixed;

	/**
	 * Finds all items that match the expression supplied in the callback
	 *
	 * @param IBooleanCallable $callback
	 * @return array
	 */
	public function findAll(IBooleanCallable $callback): mixed;

	/**
	 * @param IForeachCallback|callable $callback([$value], [$key], [$index])  Called on each item
	 */
	public function forEach(IForeachCallback|callable $callback): void;

	/**
	 * Create a shallow copy of the Collection
	 *
	 * @return $this
	 */
	public function clone(): self;

	/**
	 * Convert the Collection to an array
	 *
	 * @return array
	 */
	public function toArray(): array;

	/**
	 * Clears all the entries in the Collection
	 *
	 * @return $this
	 */
	public function clear(): self;

	/**
	 * Create a new Collection instance from an array
	 *
	 * @param array $array The array to import
	 * @return ICollection
	 */
	public static function fromArray(array $array): self;

	/**
	 * Merge the Collection into the current instance. The instance this method is executed on is leading.
	 *
	 * @param ICollection $collection The collection to merge into the current instance
	 * @return ICollection
	 */
	public function merge(ICollection $collection): self;
}
