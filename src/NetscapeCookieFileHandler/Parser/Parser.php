<?php

namespace KeGi\NetscapeCookieFileHandler\Parser;

use DateTime;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollection;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;

class Parser implements ParserInterface
{

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * Handler constructor.
     *
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {

        $this->setConfiguration($configuration);
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
     * @param string $file
     *
     * @return CookieCollectionInterface
     * @throws ParserException
     */
    public function parseFile(string $file) : CookieCollectionInterface
    {

        $cookieDir = rtrim(
                $this->getConfiguration()->getCookieDir(),
                DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;

        $file = $cookieDir . $file;

        if (!is_file($file)) {
            throw new ParserException(
                sprintf(
                    'File not found : %1$s',
                    $file
                )
            );
        }

        $fileContent = file_get_contents($file);

        if ($fileContent === false) {

            throw new ParserException(
                sprintf(
                    'Unable to read file : %1$s',
                    $file
                )
            );
        }

        return $this->parseContent($fileContent);
    }

    /**
     * @param string $filecontent
     *
     * @return CookieCollectionInterface
     */
    public function parseContent(string $filecontent
    ) : CookieCollectionInterface
    {

        $cookies = new CookieCollection();

        foreach (explode("\n", $filecontent) as $line) {

            $cookieData = array_map('trim', explode("\t", $line));

            if (count($cookieData) !== 7) {
                continue;
            }

            $expire = empty($cookieData[4]) ? null
                : new DateTime($cookieData[4]);

            $cookies->add(
                $cookieData[5],
                (new Cookie())
                    ->setDomain($cookieData[0])
                    ->setHttpOnly((bool)$cookieData[1])
                    ->setPath($cookieData[2])
                    ->setSecure((bool)$cookieData[3])
                    ->setExpire($expire)
                    ->setName($cookieData[5])
                    ->setValue($cookieData[6])
            );
        }

        return $cookies;
    }
}
