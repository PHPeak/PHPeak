<?php

namespace PHPeak\Collections;

class KeyValuePair implements IComparable
{

	public function __construct(public $key, public $value)
	{
	}

	public function getKey(): mixed
	{
		return $this->key;
	}

	public function setKey(mixed $key): self
	{
		$this->key = $key;

		return $this;
	}

	public function getValue(): mixed
	{
		return $this->value;
	}

	public function setValue(mixed $value): self
	{
		$this->value = $value;

		return $this;
	}

	public function compare(): mixed
	{
		return $this->value;
	}

}
