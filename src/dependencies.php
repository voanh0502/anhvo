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


\Illuminate\Pagination\Paginator::viewFactoryResolver(function () use ($container) {
    $view = $container->get('renderer');

    return new class($view)
    {
        private $view;
        private $template;
        private $data;

        public function __construct(\Slim\Views\PhpRenderer $view)
        {
            $this->view = $view;
        }

        public function make($template, $data = null)
        {
//            $this->template = $template;
            $this->template = 'admin/fragments/pagination.phtml';
//            echo '<pre>';
//            var_dump(method_exists($data['paginator'],'hasPages'));
//            echo '</pre>';
//            die();
            $this->data = $data;
            return $this;
        }

        public function render()
        {
            return $this->view->fetch($this->template, $this->data);
        }
    };
});

//\Illuminate\Pagination\Paginator::currentPageResolver(function () use ($request) {
//    return $request->getParam('page');
//});