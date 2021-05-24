<?php

namespace PHPeak;

use PHPeak\Autoloader\ClassLoader;
use PHPeak\Collections\Generic\Dictionary;

class Kernel
{

	public function __construct()
	{
		ClassLoader::loadServices();

		//cache
	}

	public function handleRequest(): string
	{
		$d = new Dictionary('string', 'string');
		$d->add('test', 'test');

		var_dump($d->toArray());

		return '';
	}
}
