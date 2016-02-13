<?php

namespace KeGi\NetscapeCookieFileHandler\Configuration;

use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;

trait ConfigurationTrait
{

    /**
     * @var ConfigurationInterface|null
     */
    private $configuration;

    /**
     * @return ConfigurationInterface|null
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param ConfigurationInterface|null $configuration
     *
     * @return $this
     */
    public function setConfiguration(
        ConfigurationInterface $configuration = null
    ) {
        $this->configuration = $configuration;

        return $this;
    }
}
