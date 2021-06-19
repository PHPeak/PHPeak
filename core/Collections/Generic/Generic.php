<?php

namespace PHPeak\Collections\Generic;

use Countable;
use Iterator;
use JetBrains\PhpStorm\Pure;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Exceptions\InvalidArgumentException;

abstract class Generic implements Iterator, Countable
{
	private int $currentIndex = 0;
	protected array $items = [];

	/**
	 * @var string A non-nullable type for the key, e.g. mixed, string, int, Dictionary::class
	 */
	private string $keyType;

	/**
	 * @var string A nullable type for the value, e.g. mixed, ?string, int[], ?Dictionary::class
	 */
	private string $valueType;
	private bool $isValueNullable = false;

	/**
	 * @var bool Whether the value provided is an array
	 */
	private bool $isValueArray = false;

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

	protected function validateValueType($value): void
	{
		if((!$this->isValueNullable && $value === null) || ($value !== null && !$this->isValidType($value, $this->valueType))) {
			$this->throwInvalidException($value, $this->valueType);
		}
	}

	protected function validateKeyType($key): void
	{
		if($key === null || !$this->isValidType($key, $this->keyType)) {

			$this->throwInvalidException($key, $this->keyType);
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

		$this->isValueNullable = (substr($valueType, 0, 1) === '?');
		$this->valueType = ltrim($valueType, '?');
	}

	protected function setKeyType($keyType): void
	{
		//TODO generic support with type hinting?
		//TODO array support

		if(substr($keyType, 0, 1) === '?') {
			throw new InvalidArgumentException("Key may not be nullable");
		}

		if(isset($this->keyType)) {
			return;
		}

		if(substr($keyType, -2, 2) === '[]') {
			$this->isValueArray = true;
			$this->keyType = substr($keyType, 0, strlen($keyType) - 2);
		} else {
			$this->keyType = $keyType;
		}

	}

	private function throwInvalidException($value, $dicType): void
	{
		$type = gettype($value);
		if($type === 'object') {
			$type = get_class($value);
		}

		throw new InvalidArgumentException(sprintf("Expected value to be of type '%s' but got '%s'", $dicType, $type));
	}

	private function isValidType($variable, string $type): bool
	{
		if($type === 'mixed') {
			$isValid = true;
		} else if($this->isValueArray) {
			$isValid = array_reduce($variable, fn($r, $x) => $r && $this->isScalar($x, $type) , true);
		} else if(is_scalar($variable)) {
			$isValid = $this->isScalar($variable, $type);
		} else if($type === 'array') {
			$isValid =  is_array($variable);
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
		$isMethod = 'is_' . ucfirst($type);
		return (function_exists($isMethod)) && $isMethod($variable);
	}

}
