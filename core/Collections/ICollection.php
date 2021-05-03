<?php

namespace PHPeak\Collections;

interface ICollection
{

	public function __construct(string $keyType, string $valueType);

	public function add($key, $value);

	public function remove($key): void;

	public function removeAt($index): void;

	public function get($key);

	public function getAt(int $index);

}
