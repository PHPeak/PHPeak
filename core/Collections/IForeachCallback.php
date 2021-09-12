<?php

namespace PHPeak\Collections;

interface IForeachCallback
{

	/**
	 * @param mixed $value The value or a KeyValuePair
	 * @param mixed $index The index at which the item resides
	 * @return void
	 */
	public function __invoke(mixed $value, mixed $index): void;
}
