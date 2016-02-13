<?php

namespace KeGi\NetscapeCookieFileHandler\Parser\Exception;

use Exception;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;

class ParserException extends NetscapeCookieFileHandlerException
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
        $message = 'Parser : ' . $message;

        parent::__construct($message, $code, $previous);
    }
}
