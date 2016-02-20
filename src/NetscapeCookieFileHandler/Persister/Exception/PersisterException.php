<?php

namespace KeGi\NetscapeCookieFileHandler\Persister\Exception;

use Exception;
use KeGi\NetscapeCookieFileHandler\Exception\NetscapeCookieFileHandlerException;

class PersisterException extends NetscapeCookieFileHandlerException
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
        $message = 'Persister : ' . $message;

        parent::__construct($message, $code, $previous);
    }
}
