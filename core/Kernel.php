<?php

namespace PHPeak;

use PHPeak\Autoloader\ClassLoader;
use PHPeak\Callable\IBooleanCallable;
use PHPeak\Collections\Generic\Dictionary;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Errors\Handlers\ErrorHandler;
use PHPeak\Sorting\Comparator\ComparatorDescending;
use PHPeak\Sorting\Quicksort;

class Kernel
{

	public function __construct()
	{
		ClassLoader::loadServices();
		ErrorHandler::init();

		//cache
	}

	public function handleRequest(): string
	{
		return '';
	}
}
