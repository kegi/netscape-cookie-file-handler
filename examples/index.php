<?php

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;
use KeGi\NetscapeCookieFileHandler\Handler;

require_once __DIR__ . '/../vendor/autoload.php';

echo 'Example' . PHP_EOL . PHP_EOL;

try {

    $configuration = (new Configuration())->setCookieDir(__DIR__ . '/cookies');
    $cookieJar = (new Handler($configuration))->parseFile('example.txt');

//    var_dump(json_encode($cookieJar->getAll()));
//    var_dump($cookieJar->get('key_a', 'domain2.dev')->toArray());
    var_dump($cookieJar->getAll()->toArray());

} catch (NetscapeCookieFileHandlerException $e) {

    echo 'Handler Exception :' . PHP_EOL . PHP_EOL;
    echo $e->getMessage();

} catch (Exception $e) {

    echo 'An exception occured :' . PHP_EOL . PHP_EOL;
    echo $e->getMessage();
}

