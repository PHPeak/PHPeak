<?php

namespace PHPeak\Autoloader;

use PHPeak\Attributes\ServiceAttribute;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use ReflectionClass;
use ReflectionException;
use RegexIterator;

abstract class ClassLoader
{

	private static array $instances = [];

	public static function loadServices(): void
	{
		//FIXME this is ugly
		$baseDir = __DIR__ . '/../';

		$dir = new RecursiveDirectoryIterator($baseDir);
		$iterator = new RecursiveIteratorIterator($dir);
		$regexIterator = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

		foreach($regexIterator as $value) {
			$className = 'PHPeak\\' .  str_replace([$baseDir, '.php', DIRECTORY_SEPARATOR], ['', '', '\\'], $value[0]);
			try {
				$reflection = new ReflectionClass($className);
			} catch (ReflectionException) {
				continue;
			}

			$isServiceClass = count(array_filter($reflection->getAttributes(), fn($x) => $x->getName() === ServiceAttribute::class)) === 1;
			if($isServiceClass) {
				self::$instances[] = new $className();
			}
		}
	}

	public static function registerAutoloader()
	{
		spl_autoload_register(function ($class) {
			$file = sprintf('../core%s', str_replace([__NAMESPACE__, '\\'], ['', DIRECTORY_SEPARATOR], $class).'.php');

			if (file_exists($file)) {
				require_once($file);
			}
		});
	}

}
