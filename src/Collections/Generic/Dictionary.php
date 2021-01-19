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
final class Dictionary extends Generic implements ICollection
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

	public function add($key, $value)
	{
		$keyValuePair = new KeyValuePair($key, $value);

		$this->validateKeyValuePair($keyValuePair);
		$this->items[] = $keyValuePair;
	}

	public function remove($key): void
	{
		// TODO: Implement remove() method.
	}

	public function removeAt($index): void
	{
		// TODO: Implement removeAt() method.
	}

	/**
	 * @param $key
	 * @return KeyValuePair|null
	 */
	public function get($key): ?KeyValuePair
	{
		$filtered = array_filter($this->items, fn($x) => $x->key === $key);
		return array_shift($filtered) ?? null;
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
