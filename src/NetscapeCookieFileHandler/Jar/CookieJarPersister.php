<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use DateTime;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarPersisterException;

class CookieJarPersister implements CookieJarPersisterInterface
{

    /**
     * Cookie file header
     */
    const FILE_HEADERS
        = [
            'Netscape HTTP Cookie File',
            'This file was generated by "netscape-cookie-file-handler" free PHP7 tool',
            'https://github.com/kegi/netscape-cookie-file-handler',
        ];

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(
        ConfigurationInterface $configuration
    ) {

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
     * @return CookieJarPersisterInterface
     */
    public function setConfiguration(ConfigurationInterface $configuration
    ) : CookieJarPersisterInterface
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param CookieCollectionInterface $cookies
     * @param string                    $filename
     *
     * @return CookieJarPersisterInterface
     * @throws CookieJarPersisterException
     */
    public function persist(
        CookieCollectionInterface $cookies,
        string $filename
    ) : CookieJarPersisterInterface
    {

        $cookieDir = rtrim(
                $this->getConfiguration()->getCookieDir(),
                DIRECTORY_SEPARATOR
            ) . DIRECTORY_SEPARATOR;

        $filename = $cookieDir . $filename;

        $fileContent = $this->generateFileOutput($cookies);

        if (empty($fileContent)) {

            if (is_file($filename)) {
                if (!@unlink($filename)) {

                    throw new CookieJarPersisterException(
                        sprintf(
                            'Unable to delete the cookies file : %1$s',
                            $filename
                        )
                    );
                }
            }

        } else {

            if (@file_put_contents($filename, $fileContent) === false) {

                if (file_exists($filename)) {
                    throw new CookieJarPersisterException(
                        sprintf(
                            'Unable to edit the cookies file : %1$s',
                            $filename
                        )
                    );
                } else {
                    throw new CookieJarPersisterException(
                        sprintf(
                            'Unable to create the cookies file : %1$s',
                            $filename
                        )
                    );
                }
            }
        }

        return $this;
    }

    /**
     * Returns the cookies file content or false if any cookies
     *
     * @param CookieCollectionInterface $cookies
     *
     * @return string|bool
     */
    private
    function generateFileOutput(
        CookieCollectionInterface $cookies
    ) {

        $output = '';

        foreach ($cookies->getCookies() as $domainCookies) {
            foreach ($domainCookies as $cookie) {

                /** @var CookieInterface $cookie */

                $domain = $cookie->getDomain();
                $httpOnly = $cookie->isHttpOnly();
                $path = $cookie->getPath();
                $secure = $cookie->isSecure();
                $expire = $cookie->getExpire();
                $name = $cookie->getName();
                $value = $cookie->getValue();

                if (empty($domain) || empty($name) || empty($value)) {
                    continue;
                }

                /*format data for output*/

                $httpOnly = $httpOnly ? 'TRUE' : 'FALSE';
                $secure = $secure ? 'TRUE' : 'FALSE';

                if (empty($path)) {
                    $path = '/';
                }

                if ($expire instanceof DateTime) {
                    $expire = (string)$expire->getTimestamp();
                } else {
                    $expire = '0';
                }

                /*add cookie to file*/

                $output .= implode("\t", array_map('trim', [
                        $domain,
                        $httpOnly,
                        $path,
                        $secure,
                        $expire,
                        $name,
                        $value,
                    ])) . PHP_EOL;
            }
        }

        if (empty($output)) {
            return false;
        }

        return implode(PHP_EOL, array_map(function ($line) {
            return '# ' . $line;
        }, self::FILE_HEADERS)) . PHP_EOL . PHP_EOL . $output;
    }
}
