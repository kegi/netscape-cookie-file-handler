<?php

namespace KeGi\NetscapeCookieFileHandler\Configuration;

class Configuration implements ConfigurationInterface
{

    /**
     * @var string
     */
    private $cookieDir;

    /**
     * @return string
     */
    public function getCookieDir() : string
    {
        return $this->cookieDir;
    }

    /**
     * @param string $cookieDir
     *
     * @return ConfigurationInterface
     */
    public function setCookieDir(string $cookieDir) : ConfigurationInterface
    {
        $this->cookieDir = $cookieDir;

        return $this;
    }
}
