<?php

spl_autoload_register(function ($class) {
	$file = sprintf(__DIR__ . '/../src%s', str_replace(['PHPeak', '\\'], ['', DIRECTORY_SEPARATOR], $class).'.php');

	if (file_exists($file)) {
		require_once($file);
		return true;
	}
	return false;
});
