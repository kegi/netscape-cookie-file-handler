<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Configuration;

use DateTime;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use PHPUnit_Framework_TestCase;

class CookieTest extends PHPUnit_Framework_TestCase
{

    public function testCookieDomainParameter()
    {
        $domain = 'foo';

        $cookie = new Cookie();
        $this->assertEquals(null, $cookie->getDomain());

        $cookie = $cookie->setDomain($domain);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setDomain need to return CookieInterface'
        );

        $this->assertEquals($domain, $cookie->getDomain());
    }

    public function testCookieHttpOnlyParameter()
    {
        $cookie = new Cookie();

        $this->assertFalse($cookie->isHttpOnly());

        $cookie = $cookie->setHttpOnly(true);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setHttpOnly need to return CookieInterface'
        );

        $this->assertTrue($cookie->isHttpOnly());

        /** @var CookieInterface $cookie */

        $cookie = $cookie->setHttpOnly(false);
        $this->assertFalse($cookie->isHttpOnly());
    }

    public function testCookiePathParameter()
    {
        $path = 'foo';

        $cookie = new Cookie();
        $this->assertEquals('/', $cookie->getPath());

        $cookie = $cookie->setPath($path);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setPath need to return CookieInterface'
        );

        /** @var CookieInterface $cookie */

        $this->assertEquals($path, $cookie->getPath());
    }

    public function testCookieSecureParameter()
    {
        $cookie = new Cookie();

        $this->assertFalse($cookie->isSecure());

        $cookie = $cookie->setSecure(true);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setSecure need to return CookieInterface'
        );

        $this->assertTrue($cookie->isSecure());

        /** @var CookieInterface $cookie */

        $cookie = $cookie->setSecure(false);
        $this->assertFalse($cookie->isSecure());
    }

    public function testCookieExpireParameter()
    {
        $expire = new DateTime();

        $cookie = new Cookie();
        $this->assertEquals(null, $cookie->getExpire());

        $cookie = $cookie->setExpire($expire);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setExpire need to return CookieInterface'
        );

        $this->assertEquals($expire, $cookie->getExpire());

        /** @var CookieInterface $cookie */

        $cookie = $cookie->setExpire(null);
        $this->assertEquals(null, $cookie->getExpire());
    }

    public function testCookieNameParameter()
    {
        $name = 'foo';

        $cookie = new Cookie();
        $this->assertEquals('', $cookie->getName());

        $cookie = $cookie->setName($name);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setName need to return CookieInterface'
        );

        $this->assertEquals($name, $cookie->getName());
    }

    public function testCookieValueParameter()
    {
        $value = 'foo';

        $cookie = new Cookie();
        $this->assertEquals('', $cookie->getValue());

        $cookie = $cookie->setValue($value);

        $this->assertTrue(
            ($cookie instanceof CookieInterface),
            'setValue need to return CookieInterface'
        );

        $this->assertEquals($value, $cookie->getValue());
    }

    public function testToArrayAndJson()
    {
        $cookie = new Cookie();

        $cookieToArray = $cookie->toArray();

        $this->assertArrayHasKey('domain', $cookieToArray);
        $this->assertArrayHasKey('httpOnly', $cookieToArray);
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
