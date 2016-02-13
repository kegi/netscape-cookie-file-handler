<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollection;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Tests\Parser\ParserTest;
use PHPUnit_Framework_TestCase;

class CookieJarTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test cookie file that we'll used to test the cookie jar
     */
    const COOKIE_TEST_FILE_NAME = 'example_test.txt';

    /**
     * full path test cookie file
     */
    const COOKIE_TEST_FILE
        = ParserTest::COOKIE_PATH . DIRECTORY_SEPARATOR
        . self::COOKIE_TEST_FILE_NAME;

    public function setUp()
    {
        copy(ParserTest::COOKIE_FILE, self::COOKIE_TEST_FILE);
    }

    public function tearDown()
    {
        if (file_exists(self::COOKIE_TEST_FILE)) {
            unlink(self::COOKIE_TEST_FILE);
        }

        parent::tearDown();
    }

    public function testGetterSetterCookiesFile()
    {
        $file = 'foo.txt';

        $cookieJar = $this->getCookieJar();
        $cookieJar->setCookiesFile($file);

        $this->assertEquals($file, $cookieJar->getCookiesFile());
    }

    public function testGetterSetterCookies()
    {
        $cookieJar = $this->getCookieJar();
        $this->assertTrue($cookieJar instanceof CookieJarInterface);

        $cookies = $cookieJar->getCookies();
        $this->assertTrue($cookies instanceof CookieCollectionInterface);

        $cookieJar->setCookies(new CookieCollection());
        $cookies = $cookieJar->getCookies();
        $this->assertEquals(0, count($cookies->toArray()));
    }

    public function testGetAndGetAll()
    {
        $cookieJar = $this->getCookieJar();
        $this->assertTrue($cookieJar->get('key_a') instanceof CookieInterface);
        $this->assertTrue($cookieJar->getAll() instanceof
            CookieCollectionInterface);
    }

    public function testAddAndDelete()
    {
        $cookieDomain = 'domain1.dev';
        $cookieName = 'foo';
        $cookieValue = 'bar';

        $cookieJar = $this->getCookieJar();

        $cookieJar->add(
            (new Cookie())
                ->setDomain($cookieDomain)
                ->setName($cookieName)
                ->setValue($cookieValue));

        /*read the cookie file again and check if new cookie is here*/

        $cookieJar = $this->getCookieJar();
        $this->assertTrue($cookieJar->has($cookieName, $cookieDomain));

        /*test delete*/

        $cookieJar->delete($cookieName);

        /*read the cookie file again and check if new cookie is here*/

        $cookieJar = $this->getCookieJar();
        $this->assertFalse($cookieJar->has($cookieName, $cookieDomain));
    }

    /**
     * @return CookieJarInterface
     */
    private function getCookieJar() : CookieJarInterface
    {

        $handler = new CookieFileHandler(
            (new Configuration())->setCookieDir(ParserTest::COOKIE_PATH)
        );

        return $handler->parseFile(self::COOKIE_TEST_FILE_NAME);
    }
}
