<?php

namespace PHPeak;

use PHPeak\Autoloader\ClassLoader;
use PHPeak\Callable\IBooleanCallable;
use PHPeak\Collections\Generic\Dictionary;
use PHPeak\Sorting\Quicksort;

class Kernel
{

	public function __construct()
	{
		ClassLoader::loadServices();

		//cache
	}

	public function handleRequest(): string
	{
		$d = new Dictionary('mixed', 'mixed');
		$d->add('test', 123);
		$d->add('test', 124);
		$d->add('test', 125);
		$d->add('test', 126);
		$d->add('test', 127);

		$res = $d->find(new class implements IBooleanCallable {
			public function __invoke($item): bool
			{
				return $item->value === 1235;
			}

		});

		var_dump($res);
		var_dump(Quicksort::sort($d));

		return '';
	}
}
