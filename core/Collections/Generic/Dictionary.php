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
final class Dictionary extends Generic implements IDictionary
{

	/**
	 * Dictionary constructor.
	 *
	 * @param string $keyType
	 * @param string $valueType
	 */
	public function __construct(
		string $keyType, //not nullable
		string $valueType //nullable
	) {
		$this->setKeyType($keyType);
		$this->setValueType($valueType);
	}

	public function add(mixed $key, mixed $value): int
	{
		$keyValuePair = new KeyValuePair($key, $value);

		$this->validateKeyValuePair($keyValuePair);
		$this->items[] = $keyValuePair;

		return count($this->items) - 1;
	}

	public function remove($key): void
	{
		// TODO: Implement remove() method.
	}

	public function removeAt(int $index): void
	{
		array_splice($this->items, $index, 1);
	}

	/**
	 * Get the value with the specified key or null
	 *
	 * @param $key
	 * @return KeyValuePair|null
	 */
	public function get($key): ?KeyValuePair
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


}
