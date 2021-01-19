<?php

namespace PHPeak;

use PHPeak\HTTP\Request;

class Kernel
{

	public function __construct()
	{
		$this->registerAutoloader();
	}

	public function request(): string
	{
		$request = new Request();

		return '';
	}

	private function registerAutoloader()
	{
		//TODO fix this
		spl_autoload_register(function ($class) {
			$file = sprintf('../src%s', str_replace([__NAMESPACE__, '\\'], ['', DIRECTORY_SEPARATOR], $class).'.php');

			if (file_exists($file)) {
				require_once($file);
				return true;
			}
			return false;
		});
	}

}
