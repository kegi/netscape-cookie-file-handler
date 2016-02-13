<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Parser;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use PHPUnit_Framework_TestCase;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;
use KeGi\NetscapeCookieFileHandler\Parser\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * Cookie path
     */
    const COOKIE_PATH
        = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
        . '_files' . DIRECTORY_SEPARATOR . 'cookies';

    /**
     * Cookie file that we'll used to test the parser
     */
    const COOKIE_FILE_NAME = 'example.txt';

    /**
     * full path cookie file
     */
    const COOKIE_FILE
        = self::COOKIE_PATH . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME;

    public function testParseFile()
    {

        $expectedCookiesArray = [
            'domain1.dev' => [
                'key_a' => [
                    'domain' => 'domain1.dev',
                    'httpOnly' => false,
                    'path' => '/',
                    'secure' => false,
                    'expire' => null,
                    'name' => 'key_a',
                    'value' => 'value_a',
                ],
                'key_b' => [
                    'domain' => 'domain1.dev',
                    'httpOnly' => true,
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
                    'path' => '/foo',
                    'secure' => true,
                    'expire' => null,
                    'name' => 'key_a',
                    'value' => 'true',
                ],
            ]
        ];

        $parser
            = new Parser((new Configuration())->setCookieDir(self::COOKIE_PATH));
        $cookies = $parser->parseFile(self::COOKIE_FILE_NAME);

        $this->assertTrue($cookies instanceof CookieCollectionInterface);

        $this->assertEquals(
            $expectedCookiesArray,
            $cookies->getAll()->toArray()
        );

        $this->assertEquals(
            $cookies,
            $parser->parseContent(file_get_contents(self::COOKIE_FILE))
        );
    }

    public function testParseFileMissingConfig()
    {
        $this->expectException(ParserException::class);

        $parser = new Parser();
        $parser->parseFile(self::COOKIE_FILE_NAME);
    }

    public function testParseFileMissingDirConfig()
    {

        $this->expectException(ParserException::class);

        $parser = new Parser((new Configuration())->setCookieDir(''));
        $parser->parseFile(self::COOKIE_FILE_NAME);
    }

    public function testParseUnknownFile()
    {

        $this->expectException(ParserException::class);

        $parser
            = new Parser((new Configuration())->setCookieDir(self::COOKIE_PATH));
        $parser->parseFile('unknown_file');
    }
}
