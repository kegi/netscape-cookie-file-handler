<?php

namespace KeGi\NetscapeCookieFileHandler;

use KeGi\NetscapeCookieFileHandler\Configuration\HasConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Parser\ParserInterface;

interface CookieFileHandlerInterface extends HasConfigurationInterface
{
    /**
     * @param string $file
     *
     * @return CookieJarInterface
     * @throws NetscapeCookieFileHandlerException
     */
    public function parseFile(string $file) : CookieJarInterface;

    /**
     * @param string $content
     *
     * @return CookieCollectionInterface
     */
    public function parseContent(string $content) : CookieCollectionInterface;

    /**
     * @return ParserInterface
     */
    public function getParser() : ParserInterface;

    /**
     * @param ParserInterface $parser
     *
     * @return self
     */
    public function setParser(ParserInterface $parser) : CookieFileHandlerInterface;
}
