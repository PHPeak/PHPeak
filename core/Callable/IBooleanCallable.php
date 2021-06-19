<?php

namespace PHPeak\Callable;

/**
 * A callable that MUST return a boolean
 */
interface IBooleanCallable
{

	public function __invoke(mixed $item): bool;

}
