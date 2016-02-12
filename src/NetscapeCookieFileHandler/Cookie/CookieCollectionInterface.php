<?php

namespace KeGi\NetscapeCookieFileHandler\Cookie;

use JsonSerializable;
use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;

interface CookieCollectionInterface extends JsonSerializable
{

    /**
     * @return array
     */
    public function getCookies();

    /**
     * @param array $cookies
     *
     * @return self
     * @throws CookieJarException
     */
    public function setCookies(array $cookies) : CookieCollectionInterface;

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
     * @return self
     */
    public function add(
        CookieInterface $cookie
    ) : CookieCollectionInterface;

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
     * @return self
     * @throws CookieJarException
     */
    public function delete(
        string $cookieName,
        string $domain = null
    ) : CookieCollectionInterface;

    /**
     * @param string|null $domain
     *
     * @return self
     */
    public function deleteAll(string $domain = null
    ) : CookieCollectionInterface;

    /**
     * @return array
     */
    public function toArray() : array;
}
