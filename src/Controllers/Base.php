<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:22
 */

namespace Controllers;

use Interop\Container\ContainerInterface;

class Base {
	protected $container;
	protected $view;

	public function __construct( ContainerInterface $container ) {
		$this->container = $container;
		$this->view = $container->get('view');
	}
}