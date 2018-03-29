<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 3/29/18
 * Time: 10:30
 */

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

class Category extends \Faker\Provider\Base
{
    private $_price;

    public function description()
    {
        return $this->generator->sentence(10);
    }

    public function features()
    {
        return $this->generator->paragraph(4);
    }

    public function category_id()
    {
        $cat = \Models\Category::inRandomOrder()->first();
        return $cat->id;
    }

    public function price()
    {
        $this->_price = $this->generator->numberBetween(100, 2000) * 1000;
        return $this->_price;
    }

    public function saleprice()
    {
        $val = $this->generator->optional($weight = 0.3)->numberBetween(100, $this->_price / 1000);
        if ($val !== null)
            return $val * 1000;
        return $val;
    }
}

function run($model_class, $faker, $fields = [], $count)
{
    global $container;
    $db = $container->get('db')->getConnection();
    $db->statement("SET foreign_key_checks=0");
    $model_class::truncate();
    $db->statement("SET foreign_key_checks=1");
    $generator = \Faker\Factory::create();
    $generator->addProvider(new $faker($generator));

    for ($i = 0; $i < $count; $i++) {
        $model = new $model_class();
        foreach ($fields as $field) {
            $model->$field = $generator->$field;
        }
        $model->save();
    }
}

run(\Models\Category::class, Category::class, ['name', 'description'], 5);
run(\Models\Product::class, Category::class, ['name', 'category_id', 'price', 'saleprice', 'description', 'features'], 50);