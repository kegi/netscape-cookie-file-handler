<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Jar;

use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\CookieFileHandler;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarPersisterInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarPersisterException;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarPersister;
use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollection;
use KeGi\NetscapeCookieFileHandler\Tests\CookieFileHandlerTest;
use PHPUnit_Framework_TestCase;

class CookieJarPersisterTest extends PHPUnit_Framework_TestCase
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

    public function testCookieJarPersisterInterface()
    {
        $persister = new CookieJarPersister(new Configuration());

        $this->assertTrue(
            $persister instanceof CookieJarPersisterInterface,
            'CookieJarPersister class need to implement CookieJarPersisterInterface'
        );
    }

    public function testPersistWithoutCookieDirParameter()
    {
        $this->expectException(CookieJarPersisterException::class);

        $persister
            = new CookieJarPersister((new Configuration())->setCookieDir(''));
        $persister->persist(
            new CookieCollection(),
            CookieFileHandlerTest::COOKIE_TEST_FILE_NAME
        );
    }

    public function testImcompleteCookie()
    {
        $persister = new CookieJarPersister(
            (new Configuration())
                ->setCookieDir(CookieFileHandlerTest::COOKIE_PATH)
        );

        /*clean test file*/

        $persister->persist(
            new CookieCollection(),
            CookieFileHandlerTest::COOKIE_TEST_FILE_NAME
        );

        /*cookie default path should be converted to "/" */

        $persister->persist(
            new CookieCollection([
                (new Cookie)
                    ->setDomain('foo.bar')
                    ->setPath('')
                    ->setName('foo')
                    ->setValue('bar'),
            ]),
            CookieFileHandlerTest::COOKIE_TEST_FILE_NAME
        );

        $this->assertEquals(
            '/',
            $this->getCookieJar()->get('foo')->getPath()
        );
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
