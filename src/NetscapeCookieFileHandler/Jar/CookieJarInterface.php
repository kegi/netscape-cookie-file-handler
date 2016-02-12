<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\ConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;

interface CookieJarInterface
{
    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration() : ConfigurationInterface;

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return self
     */
    public function setConfiguration(ConfigurationInterface $configuration
    ) : CookieJarInterface;

    /**
     * @return CookieCollectionInterface
     */
    public function getCookies() : CookieCollectionInterface;

    /**
     * @param CookieCollectionInterface $cookies
     *
     * @return self
     */
    public function setCookies(CookieCollectionInterface $cookies
    ) : CookieJarInterface;

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return CookieInterface|null
     */
    public function get(string $cookieName, string $domain = null);

    /**
     * @param string|null $domain
     *
     * @return CookieCollectionInterface
     */
    public function getAll(string $domain = null) : CookieCollectionInterface;

    /**
     * @param CookieInterface $cookie
     *
     * @return CookieJarInterface
     */
    public function add(
        CookieInterface $cookie
    ) : CookieJarInterface;

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return bool
     */
    public function has(string $cookieName, string $domain = null) : bool;

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return CookieJarInterface
     */
    public function delete(
        string $cookieName,
        string $domain = null
    ) : CookieJarInterface;

    /**
     * @param string|null $domain
     *
     * @return CookieJarInterface
     */
    public function deleteAll(string $domain = null) : CookieJarInterface;

    /**
     * @return CookieJarPersisterInterface
     */
    public function getPersister() : CookieJarPersisterInterface;

    /**
     * @param CookieJarPersisterInterface $persister
     *
     * @return $this
     */
    public function setPersister(CookieJarPersisterInterface $persister);
}
