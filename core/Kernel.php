<?php

namespace PHPeak;

use PHPeak\Autoloader\ClassLoader;
use PHPeak\HTTP\Request;

class Kernel
{

	public function __construct()
	{
		$this->registerAutoloader();
//TODO		$this->loadConfig();
	}

	public function handleRequest(): string
	{
		$request = new Request();

		ClassLoader::loadServices();


		var_dump($request);
		var_dump($_GET);

		return '';
	}

	private function registerAutoloader()
	{
		//TODO fix this
		spl_autoload_register(function ($class) {
			$file = sprintf('../core%s', str_replace([__NAMESPACE__, '\\'], ['', DIRECTORY_SEPARATOR], $class).'.php');

			if (file_exists($file)) {
				require_once($file);
				return true;
			}
			return false;
		});
	}

}
