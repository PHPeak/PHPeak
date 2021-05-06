<?php

namespace PHPeak;

//FIXME ewwwww
require_once('Autoloader/ClassLoader.php');

use PHPeak\Autoloader\ClassLoader;

class Kernel
{

	public function __construct()
	{
		ClassLoader::registerAutoloader();
		ClassLoader::loadServices();

		//cache
	}

	public function handleRequest(): string
	{


		return '';
	}
}
