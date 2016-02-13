<?php

namespace KeGi\NetscapeCookieFileHandler\Exception;

use Exception;

class NetscapeCookieFileHandlerException extends Exception
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
        $message = 'NetscapeCookieFileHandlerException : ' . $message;

        parent::__construct($message, $code, $previous);
    }
}
