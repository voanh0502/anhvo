<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 3/31/18
 * Time: 02:39
 */

namespace Controllers\Middlewares;

use Models\Product;
use Models\Category;
use Slim\Http\Request;
use Slim\Http\Response;

class ProductFilterMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $query = $this->checkSort($request);

        if (is_null($query))
            $query = Product::all();
        else $query = $query->get();
        $request = $request->withAttribute('products', $query);
        return $next($request, $response);
    }

    private function checkSort(Request &$request)
    {
        $sortParams = explode(',', $request->getQueryParam('sort', ''));
        if ((!isset($sortParams[0])) || is_null($sortParams[0]) || empty($sortParams[0]))
            return null;
        if ((!isset($sortParams[1])) || is_null($sortParams[1]) || empty($sortParams[1]))
            $sortParams[1] = 'asc';

        $request = $request->withAttribute('sort', $sortParams);
        return Product::orderBy($sortParams[0], $sortParams[1]);
    }
}