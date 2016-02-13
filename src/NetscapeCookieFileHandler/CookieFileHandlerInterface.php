<?php

namespace KeGi\NetscapeCookieFileHandler;

use KeGi\NetscapeCookieFileHandler\Configuration\HasConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;
use KeGi\NetscapeCookieFileHandler\Parser\ParserInterface;

interface CookieFileHandlerInterface extends HasConfigurationInterface
{
    /**
     * @param string $file
     *
     * @return CookieJarInterface
     * @throws ParserException
     */
    public function parseFile(string $file) : CookieJarInterface;

    /**
     * @param string $content
     *
     * @return CookieJarInterface
     */
    public function parseContent(string $content) : CookieJarInterface;

    /**
     * @return ParserInterface
     */
    public function getParser() : ParserInterface;

    /**
     * @param ParserInterface $parser
     *
     * @return self
     */
    public function setParser(ParserInterface $parser) : HandlerInterface;
}
