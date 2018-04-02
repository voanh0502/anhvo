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

function route(string $name, array $params = [])
{
    global $app;
    return url($app->getContainer()->get('router')->pathFor($name, $params));
}