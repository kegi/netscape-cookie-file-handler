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
     * @return self
     * @throws CookieJarPersisterException
     * @throws ParserException
     */
    public function persist(
        CookieCollectionInterface $cookies,
        string $filename
    ) : CookieJarPersisterInterface;
}
