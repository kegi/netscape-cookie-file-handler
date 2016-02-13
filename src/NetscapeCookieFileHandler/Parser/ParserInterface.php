<?php

namespace KeGi\NetscapeCookieFileHandler\Parser;

use KeGi\NetscapeCookieFileHandler\Configuration\HasConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;

interface ParserInterface extends HasConfigurationInterface
{
    /**
     * @param string $file
     *
     * @throws NetscapeCookieFileHandlerException
     *
     * @return CookieCollectionInterface
     */
    public function parseFile(string $file) : CookieCollectionInterface;

    /**
     * @param string $fileContent
     *
     * @return CookieCollectionInterface
     */
    public function parseContent(string $fileContent
    ) : CookieCollectionInterface;
}
