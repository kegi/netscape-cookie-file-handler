<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\HasConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;

interface CookieJarInterface extends HasConfigurationInterface
{

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
     * @return string|null
     */
    public function getCookiesFile();

    /**
     * @param string|null $cookiesFile
     *
     * @return self
     */
    public function setCookiesFile($cookiesFile) : CookieJarInterface;

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
     * @throws CookieJarException
     */
    public function getPersister() : CookieJarPersisterInterface;

    /**
     * @param CookieJarPersisterInterface $persister
     *
     * @return $this
     */
    public function setPersister(CookieJarPersisterInterface $persister);
}
