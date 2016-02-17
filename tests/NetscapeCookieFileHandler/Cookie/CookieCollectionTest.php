<?php

namespace KeGi\NetscapeCookieFileHandler\Test\Cookie;

use PHPUnit_Framework_TestCase;
use stdClass;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollection;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\Exception\CookieCollectionException;

class CookieCollectionTest extends PHPUnit_Framework_TestCase
{

    public function testCookieCollectionInterface()
    {
        $cookieCollection = new CookieCollection();

        $this->assertTrue(
            ($cookieCollection instanceof CookieCollectionInterface),
            'CookieCollection class need to implement CookieCollectionInterface'
        );
    }

    public function testSetCookies()
    {
        $cookieCollection = new CookieCollection();
        $this->assertEquals([], $cookieCollection->getCookies());

        $cookies = [
            (new Cookie())
                ->setDomain('foo.bar')
                ->setName('foo')
        ];

        /** @var CookieInterface[] $cookies */

        $cookieCollection->setCookies($cookies);

        /*we don't expect the cookie because the value was empty*/

        $this->assertEquals([], $cookieCollection->getCookies());

        $cookies[0]->setValue('bar');

        $cookies[] = (new Cookie())
            ->setDomain('bar.baz')
            ->setName('biz')
            ->setValue('boz');

        $cookieCollection->setCookies($cookies);

        /*now, we expect the cookie to be there, plus the new one. Ordered by domain*/

        $cookieReturnes = $cookieCollection->getCookies();

        $this->assertContains($cookies[0],
            $cookieReturnes[$cookies[0]->getDomain()]);

        $this->assertContains($cookies[1],
            $cookieReturnes[$cookies[1]->getDomain()]);
    }

    public function testWrongVariableTypeSetCookie()
    {
        $this->expectException(CookieCollectionException::class);

        $cookieCollection = new CookieCollection();
        $cookieCollection->setCookies([
            'not_supported'
        ]);
    }

    public function testWrongObjectSetCookie()
    {
        $this->expectException(CookieCollectionException::class);

        $cookieCollection = new CookieCollection();
        $cookieCollection->setCookies([
            new stdClass()
        ]);
    }

    public function testNoDomainSetCookie()
    {
        $this->expectException(CookieCollectionException::class);

        $cookieCollection = new CookieCollection();
        $cookieCollection->setCookies([
            (new Cookie())
                ->setName('foo')
        ]);
    }

    public function testNoNameSetCookie()
    {
        $this->expectException(CookieCollectionException::class);

        $cookieCollection = new CookieCollection();
        $cookieCollection->setCookies([
            (new Cookie())
                ->setDomain('foo.bar')
        ]);
    }

    public function testGet()
    {
        $cookie1 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie1')
            ->setValue('bar');

        $cookie2 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie1')
            ->setValue('baz');

        $cookie3 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie2')
            ->setValue('biz');

        $cookieCollection = new CookieCollection([
            $cookie1,
            $cookie2,
            $cookie3
        ]);

        $this->assertNull($cookieCollection->get('fake_cookie_name'));

        $this->assertEquals($cookie1, $cookieCollection->get('cookie1'));

        $this->assertEquals($cookie2,
            $cookieCollection->get('cookie1', 'domain2.dev'));

        $this->assertEquals($cookie3,
            $cookieCollection->get('cookie2', 'domain2.dev'));

        $this->assertEquals($cookieCollection, $cookieCollection->getAll());

        /*getAll tests*/

        $allFakeDomain = $cookieCollection->getAll('fake_domain');

        $this->assertTrue(
            ($allFakeDomain instanceof CookieCollectionInterface),
            'getAll always need to return a collection of cookies, even if there is no domain'
        );

        $allDomain2 = $cookieCollection->getAll('domain2.dev');

        $this->assertTrue(
            ($allDomain2 instanceof CookieCollectionInterface)
        );

        $this->assertEquals($cookie3, $cookieCollection->get('cookie2'));

        $comparativeCollection = new CookieCollection([
            $cookie2,
            $cookie3
        ]);

        $this->assertEquals($allDomain2, $comparativeCollection);
    }

    public function testAddAndHas()
    {
        $cookie1 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie1')
            ->setValue('bar');

        $cookie2 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie2')
            ->setValue('baz');

        $cookie3 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('only_for_domain1')
            ->setValue('biz');

        $cookie4 = (new Cookie())
            ->setName('should_be_added_on_both_domains')
            ->setValue('boz');

        $cookieCollection = new CookieCollection([
            $cookie1,
            $cookie2
        ]);

        /*cookie3 should only be added to domain1.dev*/

        $cookieCollection = $cookieCollection->add($cookie3);

        $this->assertTrue(
            ($cookieCollection instanceof CookieCollectionInterface),
            'add function need to return CookieCollectionInterface'
        );

        $cookieCollection->add($cookie4);

        /*cookie4 should be added to both domain1.dev and domain2.dev*/

        $this->assertNotNull(
            $cookieCollection->get($cookie3->getName(), $cookie1->getDomain())
        );

        $this->assertNull(
            $cookieCollection->get($cookie3->getName(), $cookie2->getDomain())
        );

        $this->assertNotNull(
            $cookieCollection->get($cookie4->getName(), $cookie1->getDomain())
        );

        $this->assertNotNull(
            $cookieCollection->get($cookie4->getName(), $cookie2->getDomain())
        );

        /*test has*/

        $this->assertFalse($cookieCollection->has('do_not_exists'));

        $this->assertTrue($cookieCollection->has($cookie1->getName()));

        $this->assertTrue($cookieCollection->has($cookie1->getName(),
            $cookie1->getDomain()));

        $this->assertFalse($cookieCollection->has($cookie1->getName(),
            $cookie2->getDomain()));

        $this->assertTrue($cookieCollection->has($cookie4->getName(),
            $cookie1->getDomain()));

        $this->assertTrue($cookieCollection->has($cookie4->getName(),
            $cookie2->getDomain()));
    }

    public function testAddNoDomainEmptyCollection()
    {
        $this->expectException(CookieCollectionException::class);

        $collection = new CookieCollection();
        $collection->add(
            (new Cookie())
                ->setName('foo')
                ->setValue('bar')
        );
    }

    public function testDelete()
    {
        $cookie1 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie1')
            ->setValue('bar');

        $cookie2 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie2')
            ->setValue('bar');

        $cookie3 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie1')
            ->setValue('baz');

        $cookie4 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie2')
            ->setValue('baz');

        $cookieCollection = new CookieCollection([
            $cookie1,
            $cookie2,
            $cookie3,
            $cookie4,
        ]);

        /*remove cookie1 on both domains*/

        $cookieCollection = $cookieCollection->delete($cookie1->getName());

        $this->assertTrue(
            ($cookieCollection instanceof CookieCollectionInterface),
            'remove function need to return CookieCollectionInterface'
        );

        $this->assertEquals(
            new CookieCollection([
                $cookie2,
                $cookie4,
            ]),
            $cookieCollection
        );

        /*we delete cookie2 only on domain1*/

        $cookieCollection->delete($cookie2->getName(), $cookie2->getDomain());

        $this->assertEquals(
            new CookieCollection([
                $cookie4,
            ]),
            $cookieCollection
        );
    }

    public function testDeleteAll()
    {
        $cookie1 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie1')
            ->setValue('bar');

        $cookie2 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie2')
            ->setValue('bar');

        $cookie3 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie1')
            ->setValue('baz');

        $cookie4 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie2')
            ->setValue('baz');

        $cookieCollection = new CookieCollection([
            $cookie1,
            $cookie2,
            $cookie3,
            $cookie4,
        ]);

        $cookieCollection = $cookieCollection->deleteAll();

        $this->assertTrue(
            ($cookieCollection instanceof CookieCollectionInterface),
            'remove function need to return CookieCollectionInterface'
        );

        $this->assertEquals(new CookieCollection(),
            $cookieCollection->getAll());

        $cookieCollection = new CookieCollection([
            $cookie1,
            $cookie2,
            $cookie3,
            $cookie4,
        ]);

        $cookieCollection->deleteAll($cookie3->getDomain());

        $this->assertEquals(
            new CookieCollection([
                $cookie1,
                $cookie2,
            ]),
            $cookieCollection
        );
    }

    public function testToArrayAndJson()
    {
        $cookie1 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie1')
            ->setValue('bar');

        $cookie2 = (new Cookie())
            ->setDomain('domain1.dev')
            ->setName('cookie2')
            ->setValue('bar');

        $cookie3 = (new Cookie())
            ->setDomain('domain2.dev')
            ->setName('cookie1')
            ->setValue('baz');

        $cookieCollection = new CookieCollection([
            $cookie1,
            $cookie2,
            $cookie3,
        ]);

        $collectionToArray = $cookieCollection->toArray();

        $this->assertArrayHasKey($cookie1->getDomain(), $collectionToArray);
        $this->assertArrayHasKey($cookie3->getDomain(), $collectionToArray);

        $this->assertEquals(8,
            count($collectionToArray[$cookie1->getDomain()][$cookie1->getName()]));
        $this->assertEquals(8,
            count($collectionToArray[$cookie1->getDomain()][$cookie2->getName()]));
        $this->assertEquals(8,
            count($collectionToArray[$cookie3->getDomain()][$cookie3->getName()]));

        $this->assertEquals(
            json_encode($collectionToArray),
            json_encode($cookieCollection)
        );
    }
}
