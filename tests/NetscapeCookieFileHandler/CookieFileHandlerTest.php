<?php

namespace KeGi\NetscapeCookieFileHandler\Tests;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Tests\Parser\ParserTest;
use PHPUnit_Framework_TestCase;

class CookieFileHandlerTest extends PHPUnit_Framework_TestCase
{
    public function testHandler()
    {
        $handler = new CookieFileHandler(
            (new Configuration())->setCookieDir(ParserTest::COOKIE_PATH)
        );

        $cookieJar = $handler->parseFile(ParserTest::COOKIE_FILE_NAME);

        $this->assertTrue($cookieJar instanceof CookieJarInterface);

        $cookieJar = $handler->parseContent('');

        $this->assertTrue($cookieJar instanceof CookieJarInterface);
    }
}
