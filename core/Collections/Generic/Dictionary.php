<?php

namespace PHPeak\Collections\Generic;

use PHPeak\Callable\IBooleanCallable;
use PHPeak\Collections\ICollection;
use PHPeak\Collections\IForeachCallback;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Exceptions\DuplicateKeyException;
use PHPeak\Services\TypeService;
use PHPeak\Sorting\Comparator\IComparator;

/**
 * Class Dictionary
 *
 * @package PHPeak\Collections\Generic
 * @property KeyValuePair[] $items
 */
final class Dictionary extends Generic implements IDictionary
{
	//TODO move to generic?
	use Traits\GenericTrait;

	/**
	 * {@inheritdoc}
	 */
	public function add(mixed $key, mixed $value): int
	{
		$keyValuePair = new KeyValuePair($key, $value);

		$this->validateKeyValuePair($keyValuePair);

		if($this->keyExists($key)) {
			throw new DuplicateKeyException($key);
		}

		$this->items[] = $keyValuePair;

		return count($this->items) - 1;
	}

	public function remove(mixed $key): void
	{
		$this->validateKeyType($key);

		$index = $this->indexOf($key);

		if($index !== -1) {
			unset($this->items[$key]);
		}
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
	 * {@inheritdoc}
	 */
	public function keyExists(mixed $key): bool
	{
		$existingItem = $this->findByProperty('key', $key);

		return $existingItem !== null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function contains(mixed $value): bool
	{
		$existingItem = $this->findByProperty('value', $value);

		return $existingItem !== null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function sort(?IComparator $comparator = null): ICollection
	{
		$this->items = $this->sortingAlgorithm::sort($this->items, $comparator);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function clone(): Dictionary
	{
		return (clone $this);
	}

	/**
	 * {@inheritdoc}
	 */
	public function indexOf(mixed $key): int
	{
		$index = -1;

		$this->forEach(function($item, $i) use($key, &$index) {
			$isItem = $item->key === $key;

			if($isItem) {
				$index = $i;
			}

			return $isItem;
		});

		return $index;
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray(): array
	{
		$result = [];
		$this->forEach(function($x) use(&$result) {
			$result[$x->key] = $x->value;
		});

		return $result;
	}

	/**
	 * Find an item using it's property, e.g. for a KeyValuePair that would be key or value
	 *
	 * @param string $property
	 * @param mixed $value
	 * @return KeyValuePair|null
	 */
	private function findByProperty(string $property, mixed $value): ?KeyValuePair
	{
		return $this->find(new class($property, $value) implements IBooleanCallable {

			public function __construct(private $property, private $value) {}

			public function __invoke(mixed $item): bool
			{
				return $item->{$this->property} === $this->value;
			}
		});
	}

	/**
	 * {@inheritdoc}
	 */
	public static function fromArray(array $array): self
	{
		$arrayType = TypeService::guessArrayType($array);
		$dictionary = new self($arrayType->getKeyType(), $arrayType->getValueType());

		foreach($array as $key=>$value) {
			/** @noinspection PhpUnhandledExceptionInspection Arrays can't have duplicate keys */
			$dictionary->add($key, $value);
		}

		return $dictionary;
	}

	/**
	 * {@inheritdoc}
	 */
	public function merge(ICollection $collection): ICollection
	{
		$collection->forEach(new class($this) implements IForeachCallback {
			public function __construct(private Dictionary $dictionary) {}

			public function __invoke(mixed $value, mixed $index): void
			{
				$key = $index;

				if($value instanceof KeyValuePair) {
					$key = $value->getKey();
					$value = $value->getValue();
				}

				$this->dictionary->add($key, $value);
			}
		});

		return $this;
	}

}
