<?php

namespace KeGi\NetscapeCookieFileHandler\Jar\Exception;

use Exception;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;

class CookieJarPersisterException extends NetscapeCookieFileHandlerException
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct(
        $message,
        $code = 0,
        Exception $previous = null
    ) {

        $message = 'Cookie Jar Persister : ' . $message;

        parent::__construct($message, $code, $previous);
    }
}
