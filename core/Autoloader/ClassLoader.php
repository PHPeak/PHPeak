<?php

namespace PHPeak\Autoloader;

use PHPeak\Attributes\ServiceAttribute;
use PHPeak\Exceptions\InvalidArgumentException;
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
		$baseDir = self::getCoreDirectory();

		$dir = new RecursiveDirectoryIterator($baseDir);
		$iterator = new RecursiveIteratorIterator($dir);
		$regexIterator = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

		foreach($regexIterator as $value) {
			$className = self::getRootNamespace() .  str_replace([$baseDir, '.php', DIRECTORY_SEPARATOR], ['', '', '\\'], $value[0]);
			try {
				$reflection = new ReflectionClass($className);
			} catch (ReflectionException $e) {
				throw new InvalidArgumentException($e->getMessage());
			}

			$isServiceClass = count(array_filter($reflection->getAttributes(), fn($x) => $x->getName() === ServiceAttribute::class)) === 1;
			if($isServiceClass) {
				self::$instances[] = new $className();
			}
		}
	}

	public static function registerAutoloader(bool $prepend = true): void
	{
		spl_autoload_register(self::class . '::autoloadClass', true, $prepend);
	}

	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @see ClassLoader::registerAutoloader
	 * @param string $class The class to try and load
	 * @return bool
	 */
	private static function autoloadClass(string $class): bool
	{
		$file = sprintf('%s%s', self::getCoreDirectory(), str_replace([self::getRootNamespace(), '\\'], ['', DIRECTORY_SEPARATOR], $class).'.php');

		if (file_exists($file)) {
			$res = require_once($file);
			return $res === 1;
		}

		return false;
	}

	private static function getRootNamespace(): string
	{
		return explode('\\', __NAMESPACE__)[0];
	}

	private static function getCoreDirectory(): string
	{
		return $_SERVER['DOCUMENT_ROOT'] . '/../core';
	}
}
