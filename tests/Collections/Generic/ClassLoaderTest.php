<?php

use PHPeak\Autoloader\ClassLoader;
use PHPUnit\Framework\Testcase;

class ClassLoaderTest extends Testcase
{

	public function testIsClassLoaderRegistered(): void
	{
		foreach(spl_autoload_functions() as $function) {
			if($function[0] === ClassLoader::class) {
				$this->assertTrue(true);
				return;
			}
		}

		$this->assertTrue(false);
	}

}
