<?php

namespace PHPeak\Errors\Handlers;

use ErrorException;

class ErrorHandler
{

	public static function init(): void
	{
		self::registerErrorHandler();
		self::registerExceptionHandler();
	}

	public static function handleError(int $severity, string $message, string $filename, int $lineNo): void
	{
		throw new ErrorException($message, 0, $severity, $filename, $lineNo);
	}

	private static function registerErrorHandler(): void
	{
		set_error_handler([self::class, 'handleError']);
	}

	private static function registerExceptionHandler()
	{
		//use later to show pretty 404/500/100 pages
	}

}
