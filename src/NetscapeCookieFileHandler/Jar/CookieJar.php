<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\MandatoryConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;
use KeGi\NetscapeCookieFileHandler\Persister\Persister;
use KeGi\NetscapeCookieFileHandler\Persister\PersisterInterface;

class CookieJar implements CookieJarInterface
{

    use MandatoryConfigurationTrait;

    /**
     * @var CookieCollectionInterface
     */
    private $cookies;

    /**
     * @var string
     */
    private $cookiesFile;

    /**
     * @var PersisterInterface
     */
    private $persister;

    /**
     * @param CookieCollectionInterface $cookies
     * @param ConfigurationInterface    $configuration
     * @param string                    $cookiesFile
     */
    public function __construct(
        CookieCollectionInterface $cookies,
        ConfigurationInterface $configuration,
        string $cookiesFile
    ) {
        $this->setConfiguration($configuration);
        $this->setCookies($cookies);
        $this->setCookiesFile($cookiesFile);
    }

    /**
     * @return CookieCollectionInterface
     */
    public function getCookies() : CookieCollectionInterface
    {
        return $this->cookies;
    }

    /**
     * @param CookieCollectionInterface $cookies
     *
     * @return CookieJarInterface
     */
    public function setCookies(CookieCollectionInterface $cookies
    ) : CookieJarInterface {
        $this->cookies = $cookies;

        return $this;
    }

    /**
     * @return string
     */
    public function getCookiesFile() : string
    {
        return $this->cookiesFile;
    }

    /**
     * @param string $cookiesFile
     *
     * @return CookieJarInterface
     */
    public function setCookiesFile(string $cookiesFile) : CookieJarInterface
    {
        $this->cookiesFile = $cookiesFile;

        return $this;
    }

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return CookieInterface|null
     */
    public function get(string $cookieName, string $domain = null)
    {
        return $this->getCookies()->get($cookieName, $domain);
    }

    /**
     * @param string|null $domain
     *
     * @return CookieCollectionInterface
     */
    public function getAll(string $domain = null) : CookieCollectionInterface
    {
        return $this->getCookies()->getAll($domain);
    }

    /**
     * @param CookieInterface $cookie
     *
     * @return CookieJarInterface
     */
    public function add(
        CookieInterface $cookie
    ) : CookieJarInterface {
        $this->getCookies()->add($cookie);

        return $this;
    }

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return bool
     */
    public function has(string $cookieName, string $domain = null) : bool
    {
        return $this->getCookies()->has($cookieName, $domain);
    }

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return CookieJarInterface
     */
    public function delete(
        string $cookieName,
        string $domain = null
    ) : CookieJarInterface {
        $this->getCookies()->delete($cookieName);

        return $this;
    }

    /**
     * @param string|null $domain
     *
     * @return CookieJarInterface
     */
    public function deleteAll(string $domain = null) : CookieJarInterface
    {
        $this->getCookies()->deleteAll($domain);

        return $this;
    }

    /**
     * @return CookieJarInterface
     * @throws CookieJarException
     */
    public function persist() : CookieJarInterface
    {
        $this->getPersister()
            ->persist($this->getCookies(), $this->getCookiesFile());

        return $this;
    }

    /**
     * @return PersisterInterface
     */
    public function getPersister() : PersisterInterface
    {
        return $this->persister ??
        new Persister($this->getConfiguration());
    }

    /**
     * @codeCoverageIgnore
     *
     * @param PersisterInterface $persister
     *
     * @return CookieJarInterface
     */
    public function setPersister(PersisterInterface $persister
    ) : CookieJarInterface {
        $this->persister = $persister;

        return $this;
    }
}
