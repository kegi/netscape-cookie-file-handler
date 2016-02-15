<?php

namespace KeGi\NetscapeCookieFileHandler\Tests;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;
use KeGi\NetscapeCookieFileHandler\CookieFileHandlerInterface;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Tests\Parser\ParserTest;
use PHPUnit_Framework_TestCase;

class CookieFileHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Cookie path
     */
    const COOKIE_PATH
        = __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR
        . 'cookies';

    /**
     * Cookie file that we'll used to test the parser
     */
    const COOKIE_FILE_NAME = 'example.txt';

    /**
     * full path cookie file
     */
    const COOKIE_FILE
        = self::COOKIE_PATH . DIRECTORY_SEPARATOR
        . self::COOKIE_FILE_NAME;

    /**
     * Expected Cookie file, we'll compare our generated file with this one
     */
    const EXPECTED_COOKIE_FILE_NAME = 'example_expected.txt';

    /**
     * full path cookie file
     */
    const EXPECTED_COOKIE_FILE
        = self::COOKIE_PATH . DIRECTORY_SEPARATOR
        . self::EXPECTED_COOKIE_FILE_NAME;

    /**
     * Test cookie file that we'll used to test the cookie jar
     */
    const COOKIE_TEST_FILE_NAME = 'example_test.txt';

    /**
     * full path test cookie file
     */
    const COOKIE_TEST_FILE
        = self::COOKIE_PATH . DIRECTORY_SEPARATOR
        . self::COOKIE_TEST_FILE_NAME;

    public function testHandlerInterface()
    {
        $handler = new CookieFileHandler();

        $this->assertTrue(
            $handler instanceof CookieFileHandlerInterface,
            'CookieFileHandler class need to implement CookieFileHandlerInterface'
        );
    }

    public function testHandler()
    {
        $handler = new CookieFileHandler(
            (new Configuration())->setCookieDir(self::COOKIE_PATH)
        );

        $cookieJar = $handler->parseFile(self::COOKIE_FILE_NAME);

        $this->assertTrue($cookieJar instanceof CookieJarInterface);

        $cookieJar = $handler->parseContent('');

        $this->assertTrue($cookieJar instanceof CookieJarInterface);
    }
}
