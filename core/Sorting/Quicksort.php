<?php

namespace PHPeak\Sorting;

use PHPeak\Sorting\Comparator\ComparatorDescending;
use PHPeak\Sorting\Comparator\IComparator;

class Quicksort implements ISort
{

	public static function sort(iterable $array, ?IComparator $comparator = null): iterable
	{
		if($comparator === null) {
			$comparator = new ComparatorDescending();
		}

		$arrayLength = count($array);

		if($arrayLength > 2) {
			$leftHalf = (int) $arrayLength / 2;
			$rightHalf = $arrayLength - $leftHalf;

			$leftHalf = array_slice($array, 0, $leftHalf);
			$rightHalf = array_slice($array, $rightHalf);

			$leftHalfSorted = self::sort($leftHalf, $comparator);
			$rightHalfSorted = self::sort($rightHalf, $comparator);

			return [
				...$leftHalfSorted,
				...$rightHalfSorted
			];
		} elseif($arrayLength === 2) {
			$sortDir = $comparator(reset($array), end($array));

			if($sortDir >= 0) {
				return $array;
			} elseif($sortDir < 1) {
				return [
					end($array),
					reset($array)
				];
			}
		}

		return $array;
	}

}
