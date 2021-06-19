<?php

namespace PHPeak\Collections;

interface IComparable
{

	/**
	 * @return mixed The value to use when used in a Comparator
	 */
	public function compare(): mixed;

}
