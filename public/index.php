<?php

require_once(__DIR__ . '/../private/bootstrap.php');

use PHPeak\Kernel;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo (new Kernel())->handleRequest();
