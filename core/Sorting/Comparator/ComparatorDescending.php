<?php

namespace PHPeak\Sorting\Comparator;

use PHPeak\Collections\IComparable;

class ComparatorDescending implements IComparator
{

	public function __invoke(mixed $a, mixed $b): int
	{
		if($a instanceof IComparable) {
			$a = $a->compare();
		}

		if($b instanceof IComparable) {
			$b = $b->compare();
		}


		if($a === $b) {
			return 0;
		}


		return ($a < $b) ? -1 : 1;
	}

}
