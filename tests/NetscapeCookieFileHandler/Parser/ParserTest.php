<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Parser;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Parser\ParserInterface;
use KeGi\NetscapeCookieFileHandler\Tests\CookieFileHandlerTest;
use PHPUnit_Framework_TestCase;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;
use KeGi\NetscapeCookieFileHandler\Parser\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{

    public function testParserInterface()
    {
        $parser = new Parser();

        $this->assertTrue(
            $parser instanceof ParserInterface,
            'Parser class need to implement ParserInterface'
        );
    }

    public function testParseFile()
    {
        $expectedCookiesArray = [
            'domain1.dev' => [
                'key_a' => [
                    'domain' => 'domain1.dev',
                    'httpOnly' => false,
                    'flag' => false,
                    'path' => '/',
                    'secure' => false,
                    'expire' => null,
                    'name' => 'key_a',
                    'value' => 'value a',
                ],
                'key_b' => [
                    'domain' => 'domain1.dev',
                    'httpOnly' => true,
                    'flag' => true,
                    'path' => '/',
                    'secure' => true,
                    'expire' => new \DateTime(date('Y-m-d H:i:s', 1486849760)),
                    'name' => 'key_b',
                    'value' => '123',
                ],
            ],
            'domain2.dev' => [
                'key_a' => [
                    'domain' => 'domain2.dev',
                    'httpOnly' => false,
                    'flag' => false,
                    'path' => '/foo',
                    'secure' => true,
                    'expire' => null,
                    'name' => 'key_a',
                    'value' => 'true',
                ],
            ]
        ];

        $parser = new Parser(
            (new Configuration())->setCookieDir(CookieFileHandlerTest::COOKIE_PATH)
        );

        $cookies = $parser->parseFile(CookieFileHandlerTest::COOKIE_FILE_NAME);

        $this->assertTrue($cookies instanceof CookieCollectionInterface);

        $this->assertEquals(
            $expectedCookiesArray,
            $cookies->getAll()->toArray()
        );

        $this->assertEquals(
            $cookies,
            $parser->parseContent(file_get_contents(CookieFileHandlerTest::COOKIE_FILE))
        );
    }

    public function testParseFileMissingConfig()
    {
        $this->expectException(ParserException::class);

        $parser = new Parser();
        $parser->parseFile(CookieFileHandlerTest::COOKIE_FILE_NAME);
    }

    public function testParseFileMissingDirConfig()
    {
        $this->expectException(ParserException::class);

        $parser = new Parser((new Configuration())->setCookieDir(''));
        $parser->parseFile(CookieFileHandlerTest::COOKIE_FILE_NAME);
    }

    public function testParseUnknownFile()
    {
        $this->expectException(ParserException::class);

        $parser
            = new Parser((new Configuration())->setCookieDir(CookieFileHandlerTest::COOKIE_PATH));
        $parser->parseFile('unknown_file');
    }
}
