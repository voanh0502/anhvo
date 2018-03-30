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
            'sort' => $request->getAttribute('sort', null)
        ];

        $this->view->render($response, 'admin/product-list.phtml', $data);
    }

    public function edit(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        if ($id === 'add') {
            $product = new Product();
        } else {
            $product = Product::find($id);
        }
        $this->view->render($response, 'admin/product-add.phtml', [
            'product' => $product,
            'categories' => Category::all(),
            'mode' => $id === 'add' ? 'add' : 'edit'
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