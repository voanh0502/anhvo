<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/admin', function () {
    $this->post('/upload', \Controllers\AdminProducts::class . ':upload')
        ->setName('admin.upload');

    $this->get('/products', \Controllers\AdminProducts::class . ':index')
        ->add(new \Controllers\Middlewares\ProductFilterMiddleware())
        ->setName('admin.product.index');

    $this->get('/products/add', \Controllers\AdminProducts::class . ':edit')
        ->setName('admin.product.add');

    $this->get('/products/{id}', \Controllers\AdminProducts::class . ':edit')
        ->setName('admin.product.edit');

    $this->post('/products[/{id}]', \Controllers\AdminProducts::class . ':save')
        ->setName('admin.product.save');
});

$app->get('/products', function (Request $request, Response $response) {
    return $this->renderer->render($response, 'product-list.html', [
        'body_classes' => ['page-product-list'],
        'products' => $request->getAttribute('products')
    ]);
})
    ->add(new \Controllers\Middlewares\ProductFilterMiddleware())
    ->setName('product.list');

$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $product = \Models\Product::find($args['id']);

    return $this->renderer->render($response, 'product-detail.phtml', [
        'body_classes' => ['page-product-detail'],
        'product' => $product
    ]);
})
    ->setName('product.detail');

$app->get('/', function (Request $request, Response $response, array $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', array_merge($args, [
        'body_classes' => ['page-index'],
        'categories' => \Models\Category::all(),
        'products' => \Models\Product::take(15)->get()
    ]));
})->setName('index');