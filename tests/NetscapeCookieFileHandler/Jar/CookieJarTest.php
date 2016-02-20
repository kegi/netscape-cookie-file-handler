<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Jar;

use KeGi\NetscapeCookieFileHandler\Jar\CookieJar;
use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollection;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Tests\CookieFileHandlerTest;
use PHPUnit_Framework_TestCase;

class CookieJarTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        copy(CookieFileHandlerTest::COOKIE_FILE,
            CookieFileHandlerTest::COOKIE_TEST_FILE);
    }

    public function tearDown()
    {
        if (file_exists(CookieFileHandlerTest::COOKIE_TEST_FILE)) {
            unlink(CookieFileHandlerTest::COOKIE_TEST_FILE);
        }

        parent::tearDown();
    }

    public function testCookieJarInterface()
    {
        $jar = new CookieJar(
            new CookieCollection(),
            (new Configuration())->setCookieDir(CookieFileHandlerTest::COOKIE_PATH),
            CookieFileHandlerTest::COOKIE_TEST_FILE_NAME
        );

        $this->assertTrue(
            $jar instanceof CookieJarInterface,
            'CookieJar class need to implement CookieJarInterface'
        );
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
                ->setValue($cookieValue)
        )->persist();

        /*read the cookie file again and check if new cookie is here*/

        $cookieJar = $this->getCookieJar();
        $this->assertTrue($cookieJar->has($cookieName, $cookieDomain));

        /*compare files with expected result*/

        $this->assertFileEquals(
            CookieFileHandlerTest::EXPECTED_COOKIE_FILE,
            CookieFileHandlerTest::COOKIE_TEST_FILE
        );

        /*test delete*/

        $cookieJar->delete($cookieName)->persist();

        /*read the cookie file again and check if new cookie is here*/

        $cookieJar = $this->getCookieJar();
        $this->assertFalse($cookieJar->has($cookieName, $cookieDomain));
    }

    public function testDeleteAll()
    {
        $cookieJar = $this->getCookieJar();
        $cookieJar->deleteAll()->persist();
        $this->assertFalse(file_exists(CookieFileHandlerTest::COOKIE_TEST_FILE));
    }

    /**
     * @return CookieJarInterface
     */
    private function getCookieJar() : CookieJarInterface
    {
        $handler = new CookieFileHandler(
            (new Configuration())->setCookieDir(CookieFileHandlerTest::COOKIE_PATH)
        );

        return $handler->parseFile(CookieFileHandlerTest::COOKIE_TEST_FILE_NAME);
    }
}
