<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:21
 */

namespace Controllers;


use Models\Product;
use Models\Category;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminProducts extends Base
{
    public function index(Request $request, Response $response)
    {
        $data = [
            'products' => $request->getAttribute('products'),
            'messages' => $this->flash->getMessage('product'),
            'sort' => $request->getAttribute('sort', null),
            'cat' => $request->getAttribute('catFilter', null)
        ];

        $this->view->render($response, 'admin/product-list.phtml', $data);
    }

    public function edit(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $mode = 'add';
        if ($id === 'add' || empty($id)) {
            $product = new Product();
        } else {
            $mode = 'edit';
            $product = Product::find($id);
        }
        $this->view->render($response, 'admin/product-add.phtml', [
            'product' => $product,
            'categories' => Category::all(),
            'mode' => $mode
        ]);
    }

    public function save(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        if (!isset($args['id'])) {
            // create new product
            $product = new Product($body);
//            $product->save();
            $this->flash->addMessage('product', "Sản phẩm <strong>$product->name</strong> đã được tạo thành công");

        } else {
            $product = Product::find($args['id']);
            $product->update($body);
//            $product->save();
            $this->flash->addMessage('product', "Sản phẩm <strong>$product->name</strong> đã được cập nhật thành công");
        }
        $category = Category::find($body['category_id']);
//        $category->products()->associate($product);
        $product->category()->associate($category);
        $product->save();

        return $response->withRedirect('/admin/products', 302);
    }
}