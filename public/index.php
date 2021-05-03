<?php

require_once(__DIR__ . '/../core/Kernel.php');

use PHPeak\Kernel;

echo (new Kernel())->handleRequest();
