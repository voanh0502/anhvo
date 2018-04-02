<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 3/31/18
 * Time: 03:18
 */

/**
 * @param string $url
 * @return string
 */
function url($url = '')
{
    return 'http://localhost:8081' . $url;
}

/**
 * @param string $name
 * @param array $params
 * @param array $query
 * @param bool $withBaseUrl
 * @return string
 */
function route(string $name, $params = [], $query = [], $withBaseUrl = true)
{
    global $app;
    $url = $app->getContainer()->get('router')->pathFor($name, $params);
    if (count($query) > 0) {
        $url .= '?' . http_build_query($query);
    }

    return $withBaseUrl ? url($url) : $url;
}