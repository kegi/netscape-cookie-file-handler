<?php

require_once __DIR__.'/../../vendor/autoload.php';

/*example configuration //*/

define('COOKIES_DIR', __DIR__.DIRECTORY_SEPARATOR.'cookies');
define('EXAMPLE_FILE_NAME', 'example.txt');
define('EXAMPLE_COPY_FILE_NAME', 'example_edited.txt');

/* \\ */

define('EXAMPLE_FILE', COOKIES_DIR.DIRECTORY_SEPARATOR.EXAMPLE_FILE_NAME);
define('EXAMPLE_COPY_FILE', COOKIES_DIR.DIRECTORY_SEPARATOR
    .EXAMPLE_COPY_FILE_NAME);

/**
 * This will count the total number of cookies inside examples.
 *
 * @param array $cookiesByDomain
 *
 * @return int
 */
function countCookies(array $cookiesByDomain) : int
{
    $nb = 0;

    foreach ($cookiesByDomain as $cookies) {
        $nb += count($cookies);
    }

    return $nb;
}
