<?php

namespace KeGi\NetscapeCookieFileHandler\Configuration;

interface ConfigurationInterface
{
    /**
     * @return string
     */
    public function getCookieDir() : string;

    /**
     * @param string $cookieDir
     *
     * @return self
     */
    public function setCookieDir(string $cookieDir) : ConfigurationInterface;
}
