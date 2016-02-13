<?php

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;
use KeGi\NetscapeCookieFileHandler\Handler;

require_once 'includes/example_includes.php';

echo PHP_EOL . '---' . PHP_EOL;
echo 'Example (copy cookie file and edit it)';
echo PHP_EOL . '---' . PHP_EOL . PHP_EOL;

try {

    /*for this example, we will copy the example file before editing it*/

    copy(EXAMPLE_FILE, EXAMPLE_COPY_FILE);

    /*real case implementation :*/

    $configuration = (new Configuration())->setCookieDir(COOKIES_DIR);
    $cookieJar
        = (new Handler($configuration))->parseFile(EXAMPLE_COPY_FILE_NAME);
    $nbCookies = countCookies($cookieJar->getAll()->toArray());

    $cookieJar->add(
        (new Cookie())
            ->setHttpOnly(true)
            ->setPath('/foo')
            ->setSecure(true)
            ->setExpire(new DateTime('2020-02-20 20:20:02'))
            ->setName('foo')
            ->setValue('bar')
    );

    /*Because we injected a cookie with no domain, this cookie has been added to
    all domains inside the cookie file*/

    echo 'Cookie file edited successfully !' . PHP_EOL;

    echo sprintf(
            'There were %1$d cookie(s) and now, there are %2$d cookie(s)',
            $nbCookies,
            countCookies($cookieJar->getAll()->toArray())
        ) . PHP_EOL;

    echo sprintf(
            'Compare %1$s and %2$s',
            EXAMPLE_FILE_NAME,
            EXAMPLE_COPY_FILE_NAME
        ) . PHP_EOL . PHP_EOL;
} catch (NetscapeCookieFileHandlerException $e) {
    echo 'Handler Exception :' . PHP_EOL . PHP_EOL;
    echo $e->getMessage();
} catch (Exception $e) {
    echo 'An exception occured :' . PHP_EOL . PHP_EOL;
    echo $e->getMessage();
}
