<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/admin', function () {
    $this->post('/upload', \Controllers\AdminProducts::class . ':upload');

    $this->get('/products', \Controllers\AdminProducts::class . ':index');
    $this->get('/products/{id}', \Controllers\AdminProducts::class . ':edit');
    $this->post('/products[/{id}]', \Controllers\AdminProducts::class . ':save');
});

$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $product = \Models\Product::find($args['id']);

    return $this->renderer->render($response, 'product-detail.phtml', [
        'product' => $product
    ]);
});

$app->get('/', function (Request $request, Response $response, array $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', array_merge($args, [
        'body_classes' => ['page-index'],
        'categories' => \Models\Category::all(),
        'products' => \Models\Product::take(15)->get()
    ]));
});