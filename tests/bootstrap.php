<?php

/*default timezone*/

date_default_timezone_set('UTC');

/*composer autoloader*/

$vendorPath = realpath(__DIR__ . '/../vendor');
$autoloadFile = $vendorPath . DIRECTORY_SEPARATOR . 'autoload.php';

if (!file_exists($autoloadFile)) {
    throw new Exception('Unable to locate composer autoloader');
}

require_once $autoloadFile;
