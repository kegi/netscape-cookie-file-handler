<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;

class CookieJarPersister implements CookieJarPersisterInterface
{

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(
        ConfigurationInterface $configuration
    ) {

        $this->setConfiguration($configuration);
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration() : ConfigurationInterface
    {
        return $this->configuration;
    }

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return CookieJarPersisterInterface
     */
    public function setConfiguration(ConfigurationInterface $configuration
    ) : CookieJarPersisterInterface
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param CookieCollectionInterface $cookies
     *
     * @return CookieJarPersisterInterface
     */
    public function persist(CookieCollectionInterface $cookies
    ) : CookieJarPersisterInterface
    {

    }
}
