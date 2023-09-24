<?php

namespace CalculatorViaMagic;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $calc = new Calculator();
    echo $calc->add(22, 42, 0) . PHP_EOL; // results in 64
    echo $calc->multiply(5, 6, 8) . PHP_EOL; // results in 240
    echo $calc->div(22.2, 2) . PHP_EOL; // results in 11.1
} catch (\Exception $e) {
    error_log('PHP Exception: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine() . '', 0);
    echo $e->getMessage() . PHP_EOL;
}
