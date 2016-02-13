<?php

namespace KeGi\NetscapeCookieFileHandler;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
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
     * @return CookieJarInterface
     * @throws ParserException
     */
    public function parseFile(string $file) : CookieJarInterface
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
     * @return CookieJarInterface
     */
    public function parseContent(string $content) : CookieJarInterface
    {
        return new CookieJar(
            $this->getParser()->parseContent($content),
            $this->getConfiguration()
        );
    }

    /**
     * @return ParserInterface
     */
    public function getParser() : ParserInterface
    {
        return $this->parser ?? new Parser($this->getConfiguration());
    }

    /**
     * @param ParserInterface $parser
     *
     * @return CookieFileHandlerInterface
     */
    public function setParser(ParserInterface $parser) : CookieFileHandlerInterface
    {
        $this->parser = $parser;

        return $this;
    }
}
