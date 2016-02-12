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
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return CookieInterface|null
     */
    public function get(string $cookieName, string $domain = null)
    {

        if ($domain === null) {

            /*find the first occurence on any domain*/

            foreach ($this->cookies as $cookies) {
                if (isset($cookies[$cookieName])) {
                    return $cookies[$cookieName];
                }
            }

            return null;

        } else {
            return $this->cookies[$domain][$cookieName] ?? null;
        }
    }

    /**
     * @param string|null $domain
     *
     * @return CookieCollectionInterface
     */
    public function getAll(string $domain = null) : CookieCollectionInterface
    {

        if ($domain === null) {

            return $this;

        } else {

            $collection = new CookieCollection();

            if (isset($this->cookies[$domain])) {
                foreach ($this->cookies[$domain] as $cookie) {
                    $collection->add($cookie);
                }
            }

            return $collection;
        }
    }

    /**
     * @param CookieInterface $cookie
     *
     * @return CookieCollectionInterface
     */
    public function add(
        CookieInterface $cookie
    ) : CookieCollectionInterface
    {

        $cookieDomain = $cookie->getDomain();
        $cookieName = $cookie->getName();

        if (!isset($this->cookies[$cookieDomain])) {
            $this->cookies[$cookieDomain] = [];
        }

        $this->cookies[$cookieDomain][$cookieName] = $cookie;

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

        if ($domain === null) {

            /*find this cookie for all domains*/

            foreach ($this->cookies as $cookies) {
                if (isset($cookies[$cookieName])) {
                    return true;
                }
            }

            return false;
        }

        return isset($this->cookies[$domain])
        && isset($this->cookies[$domain][$cookieName]);
    }

    /**
     * @param string      $cookieName
     * @param string|null $domain
     *
     * @return CookieCollectionInterface
     */
    public function delete(
        string $cookieName,
        string $domain = null
    ) : CookieCollectionInterface
    {

        if ($domain === null) {

            /*delete this cookie for all domains*/

            foreach ($this->cookies as $cookieDomain => $cookies) {

                if (isset($cookies[$cookieName])) {
                    unset($this->cookies[$cookieDomain][$cookieName]);
                }
            }

        } else {

            if (isset($this->cookies[$domain][$cookieName])) {
                unset($this->cookies[$domain][$cookieName]);
            }
        }

        return $this;
    }

    /**
     * @param string|null $domain
     *
     * @return CookieCollectionInterface
     */
    public function deleteAll(string $domain = null) : CookieCollectionInterface
    {

        if ($domain === null) {
            $this->cookies = [];
        } else {
            if (isset($this->cookies[$domain])) {
                $this->cookies[$domain] = [];
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $output = [];

        foreach ($this->cookies as $domain => $cookies) {

            $output[$domain] = [];

            foreach ($cookies as $cookieName => $cookie) {

                /** @var CookieInterface $cookie */

                $output[$domain][$cookieName] = $cookie->toArray();
            }
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
