<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;

class CookieJar implements CookieJarInterface
{

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @var CookieCollectionInterface
     */
    private $cookies;

    /**
     * @var CookieJarPersisterInterface
     */
    private $persister;

    /**
     * @param ConfigurationInterface    $configuration
     * @param CookieCollectionInterface $cookies
     */
    public function __construct(
        ConfigurationInterface $configuration,
        CookieCollectionInterface $cookies
    ) {

        $this->setConfiguration($configuration);
        $this->setCookies($cookies);
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
     * @return CookieJarInterface
     */
    public function setConfiguration(ConfigurationInterface $configuration
    ) : CookieJarInterface
    {
        $this->configuration = $configuration;

        return $this;
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
    ) : CookieJarInterface
    {
        $this->cookies = $cookies;

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
    ) : CookieJarInterface
    {

        $this->getCookies()->add($cookie);
        $this->getPersister()->persist($this->getCookies());

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
    ) : CookieJarInterface
    {

        $this->getCookies()->delete($cookieName);
        $this->getPersister()->persist($this->getCookies());

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
        $this->getPersister()->persist($this->getCookies());

        return $this;
    }

    /**
     * @return CookieJarPersisterInterface
     */
    public function getPersister() : CookieJarPersisterInterface
    {

        return $this->persister ??
        new CookieJarPersister($this->getConfiguration());
    }

    /**
     * @param CookieJarPersisterInterface $persister
     *
     * @return CookieJarInterface
     */
    public function setPersister(CookieJarPersisterInterface $persister
    ) : CookieJarInterface
    {
        $this->persister = $persister;

        return $this;
    }
}
