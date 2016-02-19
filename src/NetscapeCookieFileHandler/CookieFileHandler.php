<?php

namespace KeGi\NetscapeCookieFileHandler;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJarInterface;
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
     * @throws NetscapeCookieFileHandlerException
     */
    public function parseFile(string $file) : CookieJarInterface
    {
        if (!($this->getConfiguration() instanceof ConfigurationInterface)) {
            throw new NetscapeCookieFileHandlerException(
                'Configuration is mandatory with parseFile method'
            );
        }

        return new CookieJar(
            $this->getParser()->parseFile($file),
            $this->getConfiguration(),
            $file
        );
    }

    /**
     * @param string $content
     *
     * @return CookieCollectionInterface
     */
    public function parseContent(string $content) : CookieCollectionInterface
    {
        return $this->getParser()->parseContent($content);
    }

    /**
     * @return ParserInterface
     */
    public function getParser() : ParserInterface
    {
        return $this->parser ?? new Parser($this->getConfiguration());
    }

    /**
     * @codeCoverageIgnore
     *
     * @param ParserInterface $parser
     *
     * @return CookieFileHandlerInterface
     */
    public function setParser(ParserInterface $parser
    ) : CookieFileHandlerInterface {
        $this->parser = $parser;

        return $this;
    }
}
