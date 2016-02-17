<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Configuration;

use DateTime;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use PHPUnit_Framework_TestCase;

class CookieTest extends PHPUnit_Framework_TestCase
{

    public function testCookieInterface()
    {
        $cookie = new Cookie();

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'Cookie class need to implement CookieInterface'
        );
    }

    public function testCookieDomainParameter()
    {
        $domain = 'foo';

        $cookie = new Cookie();
        $this->assertEquals(null, $cookie->getDomain());

        $cookie->setDomain($domain);
        $this->assertEquals($domain, $cookie->getDomain());
    }

    public function testCookieHttpOnlyParameter()
    {
        $cookie = new Cookie();
        $this->assertFalse($cookie->isHttpOnly());

        $cookie->setHttpOnly(true);
        $this->assertTrue($cookie->isHttpOnly());

        $cookie = $cookie->setHttpOnly(false);
        $this->assertFalse($cookie->isHttpOnly());
    }

    public function testCookieFlagParameter()
    {
        $cookie = new Cookie();
        $this->assertTrue($cookie->isFlag());

        $cookie->setFlag(false);
        $this->assertFalse($cookie->isFlag());

        $cookie = $cookie->setFlag(true);
        $this->assertTrue($cookie->isFlag());
    }

    public function testCookiePathParameter()
    {
        $path = 'foo';

        $cookie = new Cookie();
        $this->assertEquals('/', $cookie->getPath());

        $cookie->setPath($path);
        $this->assertEquals($path, $cookie->getPath());
    }

    public function testCookieSecureParameter()
    {
        $cookie = new Cookie();
        $this->assertFalse($cookie->isSecure());

        $cookie->setSecure(true);
        $this->assertTrue($cookie->isSecure());

        $cookie->setSecure(false);
        $this->assertFalse($cookie->isSecure());
    }

    public function testCookieExpireParameter()
    {
        $expire = new DateTime();

        $cookie = new Cookie();
        $this->assertEquals(null, $cookie->getExpire());

        $cookie->setExpire($expire);
        $this->assertEquals($expire, $cookie->getExpire());

        $cookie->setExpire(null);
        $this->assertEquals(null, $cookie->getExpire());
    }

    public function testCookieNameParameter()
    {
        $name = 'foo';

        $cookie = new Cookie();
        $this->assertEquals('', $cookie->getName());

        $cookie->setName($name);
        $this->assertEquals($name, $cookie->getName());
    }

    public function testCookieValueParameter()
    {
        $value = 'foo';

        $cookie = new Cookie();
        $this->assertEquals('', $cookie->getValue());

        $cookie->setValue($value);
        $this->assertEquals($value, $cookie->getValue());
    }

    public function testToArrayAndJson()
    {
        $cookie = new Cookie();

        $cookieToArray = $cookie->toArray();

        $this->assertArrayHasKey('domain', $cookieToArray);
        $this->assertArrayHasKey('httpOnly', $cookieToArray);
        $this->assertArrayHasKey('flag', $cookieToArray);
        $this->assertArrayHasKey('path', $cookieToArray);
        $this->assertArrayHasKey('secure', $cookieToArray);
        $this->assertArrayHasKey('expire', $cookieToArray);
        $this->assertArrayHasKey('name', $cookieToArray);
        $this->assertArrayHasKey('value', $cookieToArray);

        $this->assertEquals(
            json_encode($cookieToArray),
            json_encode($cookie)
        );
    }
}
