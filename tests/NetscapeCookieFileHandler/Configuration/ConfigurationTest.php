<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Configuration;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use PHPUnit_Framework_TestCase;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{

    public function testCookieDirParameterTest()
    {
        $dir = 'foo';

        $configuration = new Configuration();
        $configuration = $configuration->setCookieDir($dir);

        $this->assertTrue(
            ($configuration instanceof ConfigurationInterface),
            'setCookieDir need to return ConfigurationInterface'
        );

        $this->assertEquals(
            $dir,
            $configuration->getCookieDir(),
            'holy cow'
        );
    }
}
