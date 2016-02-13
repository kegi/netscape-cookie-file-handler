<?php

namespace KeGi\NetscapeCookieFileHandler\Configuration;

interface HasConfigurationInterface
{

    /**
     * @return ConfigurationInterface|null
     */
    public function getConfiguration();

    /**
     * @param ConfigurationInterface|null $configuration
     *
     * @return $this
     */
    public function setConfiguration(
        ConfigurationInterface $configuration = null
    );
}
