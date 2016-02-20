<?php

namespace KeGi\NetscapeCookieFileHandler\Jar;

use KeGi\NetscapeCookieFileHandler\Configuration\HasMandatoryConfigurationInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieCollectionInterface;
use KeGi\NetscapeCookieFileHandler\Cookie\CookieInterface;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;
use KeGi\NetscapeCookieFileHandler\Persister\PersisterInterface;

interface CookieJarInterface extends HasMandatoryConfigurationInterface
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
     * @return string
     */
    public function getCookiesFile() : string;

    /**
     * @param string $cookiesFile
     *
     * @return self
     */
    public function setCookiesFile(string $cookiesFile) : CookieJarInterface;

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
     * @return CookieJarInterface
     * @throws CookieJarException
     */
    public function persist() : CookieJarInterface;

    /**
     * @return PersisterInterface
     */
    public function getPersister() : PersisterInterface;

    /**
     * @param PersisterInterface $persister
     *
     * @return $this
     */
    public function setPersister(PersisterInterface $persister);
}
