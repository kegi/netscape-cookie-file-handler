<?php

namespace KeGi\NetscapeCookieFileHandler;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJar;
use KeGi\NetscapeCookieFileHandler\Parser\Parser;
use KeGi\NetscapeCookieFileHandler\Parser\ParserInterface;

class CookieFileHandler implements CookieFileHandlerInterface
{

    use ConfigurationTrait;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * Handler constructor.
     *
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->setConfiguration($configuration);
    }

    /**
     * @param string $file
     *
     * @return CookieJar
     * @throws ParserException
     */
    public function parseFile(string $file) : CookieJar
    {
        return new CookieJar(
            $this->getParser()->parseFile($file),
            $this->getConfiguration(),
            $file
        );
    }

    /**
     * @param string $content
     *
     * @return CookieJar
     */
    public function parseContent(string $content) : CookieJar
    {
        return new CookieJar(
            $this->getParser()->parseContent($content),
            $this->getConfiguration()
        );
    }

    /**
     * @return ParserInterface
     */
    public function getParser()
    {
        return $this->parser ?? new Parser($this->getConfiguration());
    }

    /**
     * @param ParserInterface $parser
     *
     * @return HandlerInterface
     */
    public function setParser(ParserInterface $parser) : HandlerInterface
    {
        $this->parser = $parser;

        return $this;
    }
}
