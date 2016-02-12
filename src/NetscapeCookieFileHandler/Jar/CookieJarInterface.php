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
     * @param string $cookieName
     *
     * @return Mixed
     */
    public function get(string $cookieName);

    /**
     * @return CookieCollectionInterface
     */
    public function getAll() : CookieCollectionInterface;

    /**
     * @param string $cookieName
     * @param CookieInterface $value
     *
     * @return CookieJarInterface
     */
    public function add(
        string $cookieName,
        CookieInterface $value
    ) : CookieJarInterface;

    /**
     * @param string $cookieName
     *
     * @return bool
     */
    public function has(string $cookieName) : bool;

    /**
     * @param string $cookieName
     *
     * @return CookieJarInterface
     */
    public function delete(string $cookieName) : CookieJarInterface;

    /**
     * @return CookieJarInterface
     */
    public function deleteAll() : CookieJarInterface;

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
