<?php

class Example
{

    /**
     * test cookie path
     */
    const COOKIES_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'cookies';

    /**
     * example file to read (will be copied)
     */
    const EXAMPLE_FILE_NAME = 'example.txt';

    /**
     * example file to edit
     */
    const EXAMPLE_COPY_FILE_NAME = 'example_edited.txt';

    /**
     * full path example file to read
     */
    const EXAMPLE_FILE
        = self::COOKIES_DIR . DIRECTORY_SEPARATOR . self::EXAMPLE_FILE_NAME;

    /**
     * full path example file to edit
     */
    const EXAMPLE_COPY_FILE
        = self::COOKIES_DIR . DIRECTORY_SEPARATOR
        . self::EXAMPLE_COPY_FILE_NAME;

    /**
     * This will count the total number of cookies inside examples
     *
     * @param array $cookiesByDomain
     *
     * @return int
     */
    public static function countCookies(array $cookiesByDomain) : int
    {
        $nb = 0;

        foreach ($cookiesByDomain as $cookies) {
            $nb += count($cookies);
        }

        return $nb;
    }
}
