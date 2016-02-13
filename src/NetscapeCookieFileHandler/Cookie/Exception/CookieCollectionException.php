<?php

namespace KeGi\NetscapeCookieFileHandler\Cookie\Exception;

use Exception;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;

class CookieCollectionException extends NetscapeCookieFileHandlerException
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
        $message = 'Cookie collection : ' . $message;

        parent::__construct($message, $code, $previous);
    }
}
