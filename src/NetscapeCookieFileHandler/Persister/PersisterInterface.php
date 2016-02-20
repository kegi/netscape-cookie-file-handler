<?php

namespace KeGi\NetscapeCookieFileHandler\Persister;

use KeGi\NetscapeCookieFileHandler\Configuration\HasMandatoryConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Persister\Exception\PersisterException;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;

interface PersisterInterface extends HasMandatoryConfigurationInterface
{

    /**
     * @param CookieCollectionInterface $cookies
     * @param string                    $filename
     *
     * @return self
     * @throws PersisterException
     * @throws ParserException
     */
    public function persist(
        CookieCollectionInterface $cookies,
        string $filename
    ) : PersisterInterface;
}
