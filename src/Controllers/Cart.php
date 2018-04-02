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
    public function preview(Request $request, Response $response)
    {
        //transform cart items for preview
        $cartItems = $this->session->get('cart');
        $totalAmount = 0;
        foreach ($cartItems as $id => $cartItem) {
            $product = Product::find($cartItem['product_id']);

            $price = $product->saleprice ? $product->saleprice : $product->price;
            $price *= (int)$cartItem['quantity'];

            $cartItems[$id]['product'] = $product;
            $cartItems[$id]['amount'] = $price;
            $totalAmount += $price;
        }

        return $this->view->render($response, 'cart.phtml', [
            'body_classes' => ['page-cart'],
            'items' => $cartItems,
            'count' => count($cartItems),
            'totalAmount' => $totalAmount
        ]);
    }

    public function add(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $product = Product::find($body['product_id']);

        $entry = [];
        $entry[$product->id] = $body;

        $this->session->merge('cart', $entry);

        $this->flash->addMessage('cart', "Sản phẩm <b>{$product->name}</b> đã được thêm vào giỏ hàng. <strong><a href='" . route('cart.preview') . "'>Xem giỏ hàng</a></strong>");

        return $response->withRedirect(
            route('product.detail', ['id' => $product->id], [], false),
            302
        );
    }

    public function remove(Request $request, Response $response, $args = [])
    {
        $cartItems = $this->session->get('cart');
        $idToRemove = $args['id'];
        if ($idToRemove)
            unset($cartItems[$idToRemove]);
        else $cartItems = [];

        $this->session->set('cart', $cartItems);

        return $response->withRedirect(route('cart.preview', [], [], false), 302);
    }
}