<?php

namespace KeGi\NetscapeCookieFileHandler\Parser;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;


interface ParserInterface
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

    /**
     * @param string $file
     *
     * @return CookieCollectionInterface
     * @throws NetscapeCookieFileHandlerException
     */
    public function parseFile(string $file) : CookieCollectionInterface;

    /**
     * @param string $fileContent
     *
     * @return CookieCollectionInterface
     */
    public function parseContent(string $fileContent) : CookieCollectionInterface;
}
