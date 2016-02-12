<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;

interface CookieJarPersisterInterface
{
    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration() : ConfigurationInterface;

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return self
     */
    public function setConfiguration(ConfigurationInterface $configuration
    ) : CookieJarPersisterInterface;

    /**
     * @param CookieCollectionInterface $cookies
     * @param string                    $filename
     *
     * @return self
     */
    public function persist(
        CookieCollectionInterface $cookies,
        string $filename
    ) : CookieJarPersisterInterface;
}
