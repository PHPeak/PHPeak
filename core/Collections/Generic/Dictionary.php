<?php

namespace PHPeak\Collections\Generic;

use PHPeak\Exceptions\ArgumentOutOfRangeException;
use PHPeak\Exceptions\DuplicateKeyException;
use PHPeak\Exceptions\InvalidKeyException;
use PHPeak\Exceptions\InvalidArgumentException;
use PHPeak\Collections\ICollection;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Exceptions\NotImplementedException;

/**
 * Class Dictionary
 *
 * @package PHPeak\Collections\Generic
 * @property KeyValuePair[] $items
 */
final class Dictionary extends Generic implements ICollection, IDictionary
{

	/**
	 * Dictionary constructor.
	 *
	 * @param string $keyType
	 * @param string $valueType
	 * @throws InvalidArgumentException
	 */
	public function __construct(
		string $keyType, //not nullable
		string $valueType //nullable
	) {
		$this->setKeyType($keyType);
		$this->setValueType($valueType);

		//TODO save method for validity check instead of calculating it every time
	}

	/**
	 * @inheritdoc
	 * @throws DuplicateKeyException
	 */
	public function add(mixed $key, mixed $value): int
	{
		$keyValuePair = new KeyValuePair($key, $value);
		$this->validateKeyValuePair($keyValuePair);

		if($this->indexOf($key) !== -1) {
			throw new DuplicateKeyException($key);
		}

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
	 * @inheritdoc
	 */
	public function get(mixed $key): ?KeyValuePair
	{
		foreach($this->items as $item) {
			if($item->key === $key) {
				return $item;
			}
		}

		throw new InvalidKeyException($key);
	}

	/**
	 * @inheritdoc
	 */
	public function getAt(int $index): KeyValuePair
	{
		//TODO test this
		$result = $this->items[$index] ?? null;

		if($result === null) {
			throw new ArgumentOutOfRangeException($index);
		}

		return $result;
	}

	/**
	 * @inheritdoc
	 *
	 * @param callable $callback([$value], [$key], [$index]) Called on each item
	 */
	public function forEach(callable $callback): void {
		foreach($this as $index => $item) {
			$callback($item->value, $item->key, $index);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function keyExists(mixed $key): bool
	{
		try {
			$this->get($key);
			return true;
		} catch(InvalidKeyException $e) {
			return false;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function contains(mixed $value): bool
	{
		if(!$value instanceof KeyValuePair) {
			throw new InvalidArgumentException();
		}

		return in_array($value, $this->items, true);
	}

	/**
	 * @inheritdoc
	 */
	public function indexOf(mixed $key): int
	{
		foreach($this->items as $i => $v) {
			if($v->key === $key) {
				return $i;
			}
		}

		return -1;
	}

	/**
	 * @inheritdoc
	 * @throws NotImplementedException
	 */
	public static function fromArray(array $array): void
	{
		throw new NotImplementedException();
	}

	public function toArray(): array
	{
		//flatten the KeyValue pair [0=>KeyValuePair, 1=>KeyValuePair, ...] into a 1D array [key=>value, key=>value, ...]
		return array_merge([], ...array_map(fn($x) => [$x->key => $x->value], $this->items));
	}

}
