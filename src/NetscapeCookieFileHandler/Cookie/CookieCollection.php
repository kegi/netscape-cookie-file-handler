<?php

namespace KeGi\NetscapeCookieFileHandler\Cookie;

use KeGi\NetscapeCookieFileHandler\Cookie\Exception\CookieCollectionException;

class CookieCollection implements CookieCollectionInterface
{

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @param array $cookies
     */
    public function __construct(array $cookies = [])
    {
        if (!empty($cookies)) {
            $this->setCookies($cookies);
        }
    }

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
     * @throws CookieCollectionException
     */
    public function setCookies(array $cookies) : CookieCollectionInterface
    {
        $this->cookies = [];

        foreach ($cookies as $cookie) {
            if (!is_object($cookie)) {
                throw new CookieCollectionException(
                    sprintf(
                        'Expected CookieInterface object, got : %1$s',
                        gettype($cookie)
                    )
                );
            }

            if (!($cookie instanceof CookieInterface)) {
                throw new CookieCollectionException(
                    sprintf(
                        'Expected CookieInterface, got : %1$s',
                        get_class($cookie)
                    )
                );
            }

            if (empty($cookie->getDomain())) {
                throw new CookieCollectionException(
                    'You can\'t have a cookie with no domain when using setCookies'
                );
            }

            if (empty($cookie->getName())) {
                throw new CookieCollectionException(
                    'You can\'t have a cookie with no name'
                );
            }

            if (empty($cookie->getValue())) {
                continue;
            }

            $this->add($cookie);
        }

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
     * @throws CookieCollectionException
     */
    public function add(
        CookieInterface $cookie
    ) : CookieCollectionInterface {
        $cookieDomain = $cookie->getDomain();
        $cookieName = $cookie->getName();

        if ($cookieDomain === null) {

            /*if there is no cookie and the given cookie doesn't have a domain,
            we throw an exception*/

            if (count($this->cookies) === 0) {
                throw new CookieCollectionException(
                    'You cannot add a cookie with no domain to an empty cookie jar'
                );
            }

            /*we add this cookie to all knowns domains*/

            foreach ($this->cookies as $domain => $cookies) {
                $generatedCookie = clone $cookie;
                $generatedCookie->setDomain($domain);
                $this->cookies[$domain][$cookieName] = $generatedCookie;
            }
        } else {
            if (!isset($this->cookies[$cookieDomain])) {
                $this->cookies[$cookieDomain] = [];
            }

            $this->cookies[$cookieDomain][$cookieName] = $cookie;
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
    ) : CookieCollectionInterface {
        if ($domain === null) {

            /*delete this cookie for all domains*/

            foreach ($this->cookies as $cookieDomain => $cookies) {
                if (isset($cookies[$cookieName])) {
                    unset($this->cookies[$cookieDomain][$cookieName]);
                }

                if (empty($this->cookies[$cookieDomain])) {
                    unset($this->cookies[$cookieDomain]);
                }
            }
        } else {
            if (isset($this->cookies[$domain][$cookieName])) {
                unset($this->cookies[$domain][$cookieName]);

                if (empty($this->cookies[$domain])) {
                    unset($this->cookies[$domain]);
                }
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
                unset($this->cookies[$domain]);
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
