<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/2/18
 * Time: 13:43
 */

namespace Controllers\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;
use SlimSession\Helper;

class CartMiddleware
{
    /**
     * @var Helper
     */
    private $session;

    public function __construct()
    {
        $this->session = new Helper();
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        $cart = $this->session->get('cart', null);
        if (is_null($cart)) {
            $this->session->set('cart', []);
        }

        return $next($request, $response);
    }
}