<?php

namespace KeGi\NetscapeCookieFileHandler\Parser;

use DateTime;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Cookie\Cookie;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollection;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Parser\Exception\ParserException;

class Parser implements ParserInterface
{

    use ConfigurationTrait;

    /**
     * @param ConfigurationInterface|null $configuration
     */
    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->setConfiguration($configuration);
    }

    /**
     * @param string $file
     *
     * @return CookieCollectionInterface
     * @throws ParserException
     */
    public function parseFile(string $file) : CookieCollectionInterface
    {
        if (!($this->getConfiguration() instanceof ConfigurationInterface)) {
            throw new ParserException(
                'You need to inject configurations in order to parse a file'
            );
        }

        if (empty($this->getConfiguration()->getCookieDir())) {
            throw new ParserException(
                'You need to specify the cookieDir parameter in configurations in order to parse a file'
            );
        }

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

        $fileContent = @file_get_contents($file);

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
    ) : CookieCollectionInterface {
        $cookies = new CookieCollection();

        foreach (explode("\n", $filecontent) as $line) {
            $line = trim($line);

            if (isset($line[0]) && $line[0] === '#') {
                continue;
            }

            $cookieData = array_map('trim', explode("\t", $line));

            if (count($cookieData) !== 7) {
                continue;
            }

            $expire = empty($cookieData[4]) ? null : $cookieData[4];

            if (preg_match('#^[0-9]+$#i', $expire)) {
                $expire = new DateTime(date('Y-m-d H:i:s', (int)$expire));
            }

            $cookies->add(
                (new Cookie())
                    ->setDomain($cookieData[0])
                    ->setHttpOnly(strtolower($cookieData[1]) === 'true')
                    ->setPath($cookieData[2])
                    ->setSecure(strtolower($cookieData[3]) === 'true')
                    ->setExpire($expire)
                    ->setName($cookieData[5])
                    ->setValue($cookieData[6])
            );
        }

        return $cookies;
    }
}
