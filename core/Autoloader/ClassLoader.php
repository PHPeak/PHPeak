<?php

namespace PHPeak\Autoloader;

use PHPeak\Attributes\ServiceAttribute;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use ReflectionClass;
use RegexIterator;

class ClassLoader
{

	private static array $instances = [];

	public static function loadServices(): void
	{
		$baseDir = __DIR__ . '/../';

		$dir = new RecursiveDirectoryIterator($baseDir);
		$iterator = new RecursiveIteratorIterator($dir);
		$regexIterator = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

		foreach($regexIterator as $value) {
			$className = 'PHPeak\\' .  str_replace([$baseDir, '.php', '/'], ['', '', '\\'], $value[0]);

			$reflection = new ReflectionClass($className);
			$isServiceClass = count(array_filter($reflection->getAttributes(), fn($x) => $x->getName() === ServiceAttribute::class)) === 1;

			if($isServiceClass) {
				self::$instances[] = new $className();
			}
		}

		var_dump(self::$instances);
		echo "<br />";

	}

}
