<?php

namespace KeGi\NetscapeCookieFileHandler\Cookie;

use DateTime;
use JsonSerializable;

interface CookieInterface extends JsonSerializable
{
    /**
     * @return string|null
     */
    public function getDomain();

    /**
     * @param string|null $domain
     *
     * @return self
     */
    public function setDomain(string $domain = null) : CookieInterface;

    /**
     * @return bool
     */
    public function isHttpOnly() : bool;

    /**
     * @param bool $httpOnly
     *
     * @return self
     */
    public function setHttpOnly(bool $httpOnly) : CookieInterface;

    /**
     * @return bool
     */
    public function isFlag() : bool;

    /**
     * @param bool $flag
     *
     * @return self
     */
    public function setFlag(bool $flag) : CookieInterface;

    /**
     * @return string
     */
    public function getPath() : string;

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath(string $path)  :CookieInterface;

    /**
     * @return bool
     */
    public function isSecure() : bool;

    /**
     * @param bool $secure
     *
     * @return self
     */
    public function setSecure(bool $secure) : CookieInterface;

    /**
     * @return DateTime|null
     */
    public function getExpire();

    /**
     * @param DateTime|null $expire
     *
     * @return CookieInterface
     */
    public function setExpire($expire) : CookieInterface;

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name) : CookieInterface;

    /**
     * @return string
     */
    public function getValue() : string;

    /**
     * @param string $value
     *
     * @return self
     */
    public function setValue(string $value) : CookieInterface;

    /**
     * @return array
     */
    public function toArray() : array;
}
