<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationTrait;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;

class CookieJar implements CookieJarInterface
{

    use ConfigurationTrait;

    /**
     * @var CookieCollectionInterface
     */
    private $cookies;

    /**
     * @var string|null
     */
    private $cookiesFile;

    /**
     * @var CookieJarPersisterInterface
     */
    private $persister;

    /**
     * @param CookieCollectionInterface   $cookies
     * @param ConfigurationInterface|null $configuration
     * @param string|null                 $cookiesFile
     */
    public function __construct(
        CookieCollectionInterface $cookies,
        ConfigurationInterface $configuration = null,
        string $cookiesFile = null
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
     * @return string|null
     */
    public function getCookiesFile()
    {
        return $this->cookiesFile;
    }

    /**
     * @param string|null $cookiesFile
     *
     * @return CookieJarInterface
     */
    public function setCookiesFile($cookiesFile) : CookieJarInterface
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

        if ($this->getCookiesFile() !== null) {
            $this->getPersister()
                ->persist($this->getCookies(), $this->getCookiesFile());
        }

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
     * @throws CookieJarException
     */
    public function delete(
        string $cookieName,
        string $domain = null
    ) : CookieJarInterface {
        $this->getCookies()->delete($cookieName);

        if ($this->getCookiesFile() !== null) {
            $this->getPersister()
                ->persist($this->getCookies(), $this->getCookiesFile());
        }

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

        if ($this->getCookiesFile() !== null) {
            $this->getPersister()
                ->persist($this->getCookies(), $this->getCookiesFile());
        }

        return $this;
    }

    /**
     * @return CookieJarPersisterInterface
     * @throws CookieJarException
     */
    public function getPersister() : CookieJarPersisterInterface
    {
        if (!($this->getConfiguration() instanceof ConfigurationInterface)) {
            throw new CookieJarException(
                'When the CookieJar is linked with a file, you need to inject configurations'
            );
        }

        return $this->persister ??
        new CookieJarPersister($this->getConfiguration());
    }

    /**
     * @param CookieJarPersisterInterface $persister
     *
     * @return CookieJarInterface
     */
    public function setPersister(CookieJarPersisterInterface $persister
    ) : CookieJarInterface {
        $this->persister = $persister;

        return $this;
    }
}
