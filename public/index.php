<?php

require_once(__DIR__ . '/../private/bootstrap.php');

use PHPeak\Kernel;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo (new Kernel())->handleRequest();

$d = \PHPeak\Collections\Generic\Dictionary::fromArray([
	0 => 'test', 'test'
]);

$d2 = \PHPeak\Collections\Generic\Dictionary::fromArray([
	2 => 'piemelbrie'
]);

$d->merge($d2);


dump($d);
