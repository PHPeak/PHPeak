<?php

require_once(__DIR__ . '/../private/bootstrap.php');

use PHPeak\Kernel;

echo (new Kernel())->handleRequest();
