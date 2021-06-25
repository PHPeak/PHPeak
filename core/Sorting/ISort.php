<?php

namespace PHPeak\Sorting;

use PHPeak\Sorting\Comparator\IComparator;

interface ISort
{

	public static function sort(array $array, IComparator $comparator = null): iterable;

}
