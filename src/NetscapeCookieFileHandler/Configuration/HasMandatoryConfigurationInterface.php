<?php

namespace KeGi\NetscapeCookieFileHandler\Configuration;

interface HasMandatoryConfigurationInterface
{

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration() : ConfigurationInterface;

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return $this
     */
    public function setConfiguration(ConfigurationInterface $configuration);
}
