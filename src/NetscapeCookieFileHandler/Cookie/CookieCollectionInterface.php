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
     * @param string $cookieName
     *
     * @return CookieInterface|null
     */
    public function get(string $cookieName);

    /**
     * @param string $cookieName
     * @param CookieInterface $cookie
     *
     * @return self
     */
    public function add(
        string $cookieName,
        CookieInterface $cookie
    ) : CookieCollectionInterface;

    /**
     * @param string $cookieName
     *
     * @return bool
     */
    public function has(string $cookieName) : bool;

    /**
     * @param string $cookieName
     *
     * @return self
     * @throws CookieJarException
     */
    public function delete(string $cookieName) : CookieCollectionInterface;

    /**
     * @return self
     */
    public function deleteAll() : CookieCollectionInterface;

    /**
     * @return array
     */
    public function toArray() : array;
}
