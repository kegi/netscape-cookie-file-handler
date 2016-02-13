<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\HasMandatoryConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarPersisterException;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;

interface CookieJarPersisterInterface extends HasMandatoryConfigurationInterface
{
    /**
     * @param CookieCollectionInterface $cookies
     * @param string                    $filename
     *
     * @throws CookieJarPersisterException
     * @throws ParserException
     *
     * @return self
     */
    public function persist(
        CookieCollectionInterface $cookies,
        string $filename
    ) : CookieJarPersisterInterface;
}
