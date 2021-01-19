<?php

namespace PHPeak\Collections\Generic;

use Iterator;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Exceptions\InvalidArgumentException;

abstract class Generic implements Iterator
{
	private int $currentIndex = 0;
	protected array $items = [];

	/**
	 * @var string A non-nullable type for the key, e.g. string, int, Dictionary
	 */
	private string $keyType;

	/**
	 * @var string A nullable type for the value, e.g. ?string, int, Dictionary
	 */
	private string $valueType;
	private bool $isValueNullable = false;


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
		if(substr($keyType, 0, 1) === '?') {
			throw new InvalidArgumentException("Key may not be nullable");
		}

		if(isset($this->keyType)) {
			return;
		}

		$this->keyType = $keyType;
	}

	private function throwInvalidException($value, $dicType): void
	{
		$type = gettype($value);
		if($type === 'object') {
			$type = get_class($value);
		}

		throw new InvalidArgumentException(sprintf("Expected value to be of type '%s' but got '%s'", $dicType, $type));
	}
	private function isValidType($variable, $type): bool
	{
		if(is_scalar($variable)) {
			//all scalars have a function like is_string, is_int...
			$isMethod = 'is_' . ucfirst($type);
			$isValid = (function_exists($isMethod)) && $isMethod($variable);
		} else if($type === 'array') {
			$isValid =  is_array($variable);
		} else {
			$isValid = is_object($variable) && $type === get_class($variable);
		}

		return $isValid;
	}

}
