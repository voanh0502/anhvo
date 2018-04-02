<?php
// DIC configuration

$container = $app->getContainer();

// view renderer

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    $product_count = \Models\Product::count();

    return new Slim\Views\PhpRenderer($settings['template_path'], array_merge($c->get('settings')['globalVars'], [
        'site' => [
            'productCount' => $product_count
        ]
    ]));
};