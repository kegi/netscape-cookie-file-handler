<?php

namespace KeGi\NetscapeCookieFileHandler\Cookie;

use KeGi\NetscapeCookieFileHandler\Jar\Exception\CookieJarException;

class CookieCollection implements CookieCollectionInterface
{

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param array $cookies
     *
     * @return CookieCollectionInterface
     * @throws CookieJarException
     */
    public function setCookies(array $cookies) : CookieCollectionInterface
    {

        foreach ($cookies as $cookie) {

            if (!is_object($cookie)) {
                throw new CookieJarException(
                    sprintf(
                        'Expected CookieInterface, got : %1$s',
                        gettype($cookie)
                    )
                );
            }

            if ($cookie instanceof CookieInterface) {
                throw new CookieJarException(
                    sprintf(
                        'Expected CookieInterface, got : %1$s',
                        get_class($cookie)
                    )
                );
            }
        }

        $this->cookies = $cookies;

        return $this;
    }

    /**
     * @param string $cookieName
     *
     * @return CookieInterface|null
     */
    public function get(string $cookieName)
    {

        return $this->cookies[$cookieName] ?? null;

    }

    /**
     * @param string          $cookieName
     * @param CookieInterface $cookie
     *
     * @return CookieCollectionInterface
     */
    public function add(
        string $cookieName,
        CookieInterface $cookie
    ) : CookieCollectionInterface
    {

        $this->cookies[$cookieName] = $cookie;

        return $this;
    }

    /**
     * @param string $cookieName
     *
     * @return bool
     */
    public function has(string $cookieName) : bool
    {

        return isset($this->cookies[$cookieName]);
    }

    /**
     * @param string $cookieName
     *
     * @return CookieCollectionInterface
     * @throws CookieJarException
     */
    public function delete(string $cookieName) : CookieCollectionInterface
    {

        if (!isset($this->cookies[$cookieName])) {
            throw new CookieJarException(
                sprintf(
                    'Unable to delete non-existent cookie : %1$s',
                    $cookieName
                )
            );
        }

        unset($this->cookies[$cookieName]);

        return $this;
    }

    /**
     * @return CookieCollectionInterface
     */
    public function deleteAll() : CookieCollectionInterface
    {

        $this->cookies = [];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $output = [];

        foreach ($this->cookies as $cookieName => $cookie) {

            /** @var CookieInterface $cookie */

            $output[$cookieName] = $cookie->toArray();
        }

        return $output;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }
}
