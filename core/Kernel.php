<?php

namespace PHPeak;

use PHPeak\Autoloader\ClassLoader;

class Kernel
{

	public function __construct()
	{
		ClassLoader::loadServices();

		//cache
	}

	public function handleRequest(): string
	{


		return '';
	}
}
