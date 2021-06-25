<?php

namespace PHPeak\Collections\Generic\Traits;

use PHPeak\Callable\IBooleanCallable;

trait GenericTrait
{

	/**
	 * Loop over each item in the Collection.
	 *
	 * @param callable $callback([$value], [$index]) Called on each item
	 * 												Optionally the callback may return true/false whether the foreach should break
	 * 												If true is supplied the loop will stop. If anything else is supplied the loop will continue
	 */
	public function forEach(callable $callback): void
	{
		foreach($this as $index => $item) {
			$break = $callback($item, $index);

			if($break === true) {
				break;
			}
		}
	}

	/**
	 * Get the value at the specified index or null
	 *
	 * @param int $index
	 * @return mixed The value at the index or null
	 */
	public function getAt(int $index): mixed
	{
		return $this->items[$index] ?? null;
	}

	/**
	 * Remove an element at the given index
	 *
	 * @param int $index
	 */
	public function removeAt(int $index): void
	{
		array_splice($this->items, $index, 1);
	}

	/**
	 * Finds the first item that matches the expression supplied in the callback
	 *
	 * @param IBooleanCallable $callback
	 * @return mixed
	 */
	public function find(IBooleanCallable $callback): mixed
	{
		$returnValue = null;

		$this->forEach(function($item) use($callback, &$returnValue) {
			$isItem = $callback($item);

			if($isItem) {
				$returnValue = $item;
			}

			return $isItem;
		});

		return $returnValue;
	}

	/**
	 * Finds all items that match the expression supplied in the callback
	 *
	 * @param IBooleanCallable $callback
	 * @return array
	 */
	public function findAll(IBooleanCallable $callback): array
	{
		$returnValue = [];

		$this->forEach(function($item) use($callback, &$returnValue) {
			if($callback($item)) {
				$returnValue[] = $item;
			}
		});

		return $returnValue;
	}

	/**
	 * Clears all the entries in the Collection
	 *
	 * @return $this
	 */
	public function clear(): self
	{
		$this->items = [];

		return $this;
	}
}
