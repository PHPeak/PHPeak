<?php

namespace PHPeak\Collections\Generic;

use PHPeak\Collections\ICollection;
use PHPeak\Collections\KeyValuePair;

/**
 * Class Dictionary
 *
 * @package PHPeak\Collections\Generic
 * @property KeyValuePair[] $items
 */
final class ArrayList extends Generic // implements IList
{

	/**
	 * List constructor.
	 *
	 * @param string $valueType
	 */
	public function __construct(
		string $valueType //nullable
	) {
		$this->setValueType($valueType);
	}

	public function add(mixed $value): int
	{
		$this->items[] = $value;

		return count($this->items) - 1;
	}

  /**
   * Remove the element with the given value
   *
   * @param $value
   */
	public function remove(mixed $value): void
	{
		$this->validateValueType($value);

		$this->items = array_filter($this->items, fn($item) => $item !== $value);
	}

	public function removeAt(int $index): void
	{
    unset($this->items[$index]);
	}

	/**
	 * Get the value with the specified key or null
	 *
	 * @param mixed $key
	 * @return KeyValuePair|null
	 */
	public function get(mixed $key): ?KeyValuePair
	{
		$filtered = array_filter($this->items, fn($x) => $x->key === $key);
		return array_shift($filtered) ?? null;
	}

	/**
	 * Get the value at the specified index or null
	 *
	 * @param int $index
	 * @return KeyValuePair|null
	 */
	public function getAt(int $index): ?KeyValuePair
	{
		return $this->items[$index] ?? null;
	}

	/**
	 * @param callable $callback([$value], [$key], [$index])  Called on each item
	 */
	public function forEach(callable $callback) {
		foreach($this as $index => $item) {
			$callback($item->value, $item->key, $index);
		}
	}

	public function contains($value)
	{
		// TODO: Implement contains() method.
	}

}
