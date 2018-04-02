<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/2/18
 * Time: 12:54
 */

namespace Controllers;


use Models\Product;
use Slim\Http\Request;
use Slim\Http\Response;

class Cart extends Base
{
    public function add(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $product = Product::find($body['product_id']);

        $this->session->merge('cart', [$body]);

        $this->flash->addMessage('cart', "Sản phẩm <b>{$product->name}</b> đã được thêm vào giỏ hàng. <a>Xem giỏ hàng</a>");

        return $response->withRedirect(
            route('product.detail', ['id' => $product->id], [], false),
            302
        );
    }
}