<?php

namespace KeGi\NetscapeCookieFileHandler\Cookie;

use DateTime;

class Cookie implements CookieInterface
{

    /**
     * @var string|null
     */
    private $domain;

    /**
     * @var bool
     */
    private $httpOnly = false;

    /**
     * @var bool
     */
    private $flag = true;

    /**
     * @var string
     */
    private $path = '/';

    /**
     * @var bool
     */
    private $secure = false;

    /**
     * @var DateTime|null
     */
    private $expire;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $value = '';

    /**
     * @return string|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string|null $domain
     *
     * @return CookieInterface
     */
    public function setDomain(string $domain = null) : CookieInterface
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHttpOnly() : bool
    {
        return $this->httpOnly;
    }

    /**
     * @param bool $httpOnly
     *
     * @return CookieInterface
     */
    public function setHttpOnly(bool $httpOnly) : CookieInterface
    {
        $this->httpOnly = $httpOnly;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFlag() : bool
    {
        return $this->flag;
    }

    /**
     * @param bool $flag
     *
     * @return CookieInterface
     */
    public function setFlag(bool $flag) : CookieInterface
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return CookieInterface
     */
    public function setPath(string $path) : CookieInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure() : bool
    {
        return $this->secure;
    }

    /**
     * @param bool $secure
     *
     * @return CookieInterface
     */
    public function setSecure(bool $secure) : CookieInterface
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param DateTime|null $expire
     *
     * @return CookieInterface
     */
    public function setExpire($expire) : CookieInterface
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return CookieInterface
     */
    public function setName(string $name) : CookieInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return CookieInterface
     */
    public function setValue(string $value) : CookieInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'domain' => $this->getDomain(),
            'httpOnly' => $this->isHttpOnly(),
            'flag' => $this->isFlag(),
            'path' => $this->getPath(),
            'secure' => $this->isSecure(),
            'expire' => $this->getExpire(),
            'name' => $this->getName(),
            'value' => $this->getValue(),
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }
}
