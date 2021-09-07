<?php

namespace PHPeak\Collections\Generic;

use Countable;
use Iterator;
use JetBrains\PhpStorm\Pure;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Exceptions\InvalidArgumentException;
use PHPeak\Sorting\ISort;
use PHPeak\TypeHinting\AbstractValueType;
use PHPeak\TypeHinting\ValueTypeImmutable;

abstract class Generic implements Iterator, Countable
{

	private const KEY = 0;
	private const VALUE = 1;

	/**
	 * @var ISort The class to use when calling the self::sort method, needs to be an instance since we can't reference types
	 */
	public ISort $sortingAlgorithm;
	protected array $items = [];

	private int $currentIndex = 0;

	/**
	 * @var string A non-nullable type for the key, e.g. mixed, string, int, Dictionary::class
	 */
	private string $keyType;
	/**
	 * @var AbstractValueType A nullable type for the value, e.g. mixed, ?string, int[], ?Dictionary::class
	 */
	private AbstractValueType $valueType;

	/**
	 * Dictionary constructor.
	 *
	 * @param string $keyType A non-nullable, non-array type to use for the key, e.g. mixed, string, int, Parameter::class
	 * @param string $valueType A nullable type to use for the value, e.g. ?string, int[], ?Parameter::Class, mixed
	 */
	#[Pure]
	public function __construct(
		string $keyType,
		string $valueType
	) {
		$this->setKeyType($keyType);
		$this->setValueType($valueType);
	}

	public function current()
	{
		return $this->items[$this->currentIndex];
	}

	public function next(): void
	{
		$this->currentIndex++;
	}

	public function key(): int
	{
		return $this->currentIndex;
	}

	public function valid(): bool
	{
		return isset($this->items[$this->currentIndex]);
	}

	public function rewind()
	{
		$this->currentIndex = 0;
	}

	#[Pure]
	public function count(): int
	{
		return count($this->items);
	}

	/**
	 * Get the textual representation of the key/value's type. E.g. string[]
	 *
	 * @param int $type KEY or VALUE
	 * @see self::KEY
	 * @see self::VALUE
	 *
	 * @return string
	 */
	public function getTypeAsString(int $type): string
	{
		if($type === self::KEY) {
			return $this->keyType;
		} else if($type === self::VALUE) {
			return $this->valueType->getType() . ($this->valueType->isArray() ? '[]' : '');
		}

		throw new InvalidArgumentException('Unknown type');
	}

	/**
	 * Check whether the value supplied matches the value's type set in the Collection's constructor
	 *
	 * @param $value mixed The key's value to check
	 */
	protected function validateValueType(mixed $value): void
	{
		if((!$this->valueType->isNullable() && $value === null) || ($value !== null && !$this->isValidType($value, $this->valueType->getType(), self::VALUE))) {
			$this->throwInvalidException($value, $this->getTypeAsString(self::VALUE));
		}
	}

	/**
	 * Check whether the key supplied matches the key's type set in the Collection's constructor
	 *
	 * @param $key mixed The key's value to check
	 */
	protected function validateKeyType(mixed $key): void
	{
		if($key === null || !$this->isValidType($key, $this->keyType, self::KEY)) {
			$this->throwInvalidException($key, $this->getTypeAsString(self::KEY));
		}
	}

	protected function validateKeyValuePair(KeyValuePair $keyValuePair): void
	{
		$this->validateKeyType($keyValuePair->key);
		$this->validateValueType($keyValuePair->value);
	}

	protected function setValueType($valueType): void
	{
		if(isset($this->valueType)) {
			return;
		}

		$this->valueType = $this->determineType($valueType);
	}

	protected function setKeyType($keyType): void
	{
		if(isset($this->keyType)) {
			return;
		}

		$type = $this->determineType($keyType);
		if($type->isNullable()) {
			throw new InvalidArgumentException("Key may not be nullable");
		} else if($type->isArray()) {
			throw new InvalidArgumentException("Key may not be an array");
		}

		$this->keyType = $type->getType();
	}

	private function throwInvalidException($value, $dicType): void
	{
		$type = gettype($value);
		if($type === 'object') {
			$type = get_class($value);
		}

		throw new InvalidArgumentException(sprintf("Expected value to be of type '%s' but got '%s'", $dicType, $type));
	}

	/**
	 * Validate a variable against the type set in the constructor
	 *
	 * @param mixed $variable The variable to check
	 * @param string $type The type to check the variable for
	 * @param int $propertyToCheck @see self::KEY, @see self::VALUE
	 * @param bool $isRecursive If an array is passed, we recursively check whether the values in the array are of the proper type. With this flag we check whether we are checking the array or the array's elements
	 * 							If $isRecursive is true, we are inside the array, otherwise we aren't
	 * @return bool Whether $variable has the right $type
	 */
	private function isValidType(mixed $variable, string $type, int $propertyToCheck, bool $isRecursive = false): bool
	{
		if($type === 'mixed') {
			$isValid = true;
		} else if($propertyToCheck === self::VALUE && !$isRecursive && $this->valueType->isArray()) {
			$isValid = is_array($variable);

			if($isValid) {
				foreach($variable as $item) {
					$isValid = $this->isValidType($item, $type, $propertyToCheck, true);

					if(!$isValid) {
						$this->throwInvalidException($item, $this->getTypeAsString(self::VALUE));
					}
				}
			}

		} else if(is_scalar($variable)) {
			$isValid = $this->isScalar($variable, $type);
		} else {
			$isValid = is_object($variable) && $type === get_class($variable);
		}

		return $isValid;
	}

	/**
	 * Checks whether the variable has the scalar type provided in $type
	 * All scalars have a function like is_string, is_int...
	 *
	 * @param $variable mixed The variable to check
	 * @param string $type The
	 * @return bool
	 */
	private function isScalar(mixed $variable, string $type): bool
	{
		$isMethod = 'is_' . strtolower($type);
		return (function_exists($isMethod)) && $isMethod($variable);
	}

	/**
	 * @param string $valueType
	 * @return AbstractValueType
	 */
	private function determineType(string $valueType): AbstractValueType
	{
		return new ValueTypeImmutable($valueType);
	}
}
