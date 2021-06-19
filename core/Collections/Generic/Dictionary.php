<?php

namespace PHPeak\Collections\Generic;

use PHPeak\Callable\IBooleanCallable;
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
	//TODO move to generic?
	use GenericTrait;

	/**
	 * Dictionary constructor.
	 *
	 * @param string $keyType A non-nullable type to use for the key, e.g. any, string, int, Parameter::class
	 * @param string $valueType A nullable type to use for the value, e.g. ?string, int[], ?Parameter::Class, any
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

	public function keyExists(mixed $key): bool
	{
		// TODO: Implement keyExists() method.
	}

	public function contains(mixed $value): bool
	{
		// TODO: Implement contains() method.
	}

	public function sort(callable $fn = null): ICollection
	{
		// TODO: Implement sort() method.
	}

	public function clone(): self
	{
		return (clone $this);
	}

	public function indexOf(mixed $key): ?int
	{
		// TODO: Implement indexOf() method.
	}

}
