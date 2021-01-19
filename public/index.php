<?php

require_once(__DIR__ . '/../src/Kernel.php');

use PHPeak\Kernel;

echo (new Kernel())->request();
