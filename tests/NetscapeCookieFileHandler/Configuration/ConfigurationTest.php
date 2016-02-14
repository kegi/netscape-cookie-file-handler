<?php

namespace KeGi\NetscapeCookieFileHandler\Tests\Configuration;

use KeGi\NetscapeCookieFileHandler\Configuration\Configuration;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use PHPUnit_Framework_TestCase;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{

    public function testConfigurationInterface()
    {
        $configuration = new Configuration();

        $this->assertTrue(
            ($configuration instanceof ConfigurationInterface),
            'Configuration class need to implement ConfigurationInterface'
        );
    }

    public function testCookieDirParameterTest()
    {
        $dir = 'foo';

        $configuration = new Configuration();
        $configuration->setCookieDir($dir);

        $this->assertEquals(
            $dir,
            $configuration->getCookieDir()
        );
    }
}
