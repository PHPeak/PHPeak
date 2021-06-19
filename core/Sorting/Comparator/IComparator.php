<?php

namespace PHPeak\Sorting\Comparator;

interface IComparator
{

	/**
	 * @param mixed $a
	 * @param mixed $b
	 * @return int -1, 0, or 1
	 */
	public function __invoke(mixed $a, mixed $b): int;

}
