<?php

namespace PHPeak\Sorting;

use PHPeak\Sorting\Comparator\ComparatorAscending;
use PHPeak\Sorting\Comparator\IComparator;

class Quicksort implements ISort
{

	public static function sort(array $array, ?IComparator $comparator = null): array
	{
		if($comparator === null) {
			$comparator = new ComparatorAscending();
		}

		$arrayLength = count($array);

		if($arrayLength < 2) {
			return $array;
		}

		$leftHalf = $rightHalf = [];
		$pivotKey = array_key_first($array);
		$pivot = reset($array);
		unset($array[$pivotKey]);

		foreach($array as $key => $item) {
			if($comparator($item, $pivot) < 0) {
				$leftHalf[$key] = $item;
			} else {
				$rightHalf[$key] = $item;
			}
		}

		return (self::sort($leftHalf, $comparator) + [$pivotKey => $pivot] + self::sort($rightHalf, $comparator));
	}

}
