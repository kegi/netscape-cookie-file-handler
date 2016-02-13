<?php

namespace KeGi\NetscapeCookieFileHandler;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;
use KeGi\NetscapeCookieFileHandler\Jar\CookieJar;
use KeGi\NetscapeCookieFileHandler\Parser\Parser;

class Handler
{

    use ConfigurationTrait;

    /**
     * @var Parser
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
     * @return ConfigurationInterface
     */
    public function getConfiguration() : ConfigurationInterface
    {
        return $this->configuration;
    }

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return $this
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser ?? new Parser($this->getConfiguration());
    }

    /**
     * @param Parser $parser
     *
     * @return $this
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }
}
