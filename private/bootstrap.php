<?php

use PHPeak\Autoloader\ClassLoader;

if(empty($_SERVER['DOCUMENT_ROOT'])) {
	$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
}

require_once(__DIR__ . '/../core/Autoloader/ClassLoader.php');

ClassLoader::registerAutoloader();

