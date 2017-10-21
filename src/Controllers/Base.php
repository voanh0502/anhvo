<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:22
 */

namespace Controllers;

use Interop\Container\ContainerInterface;
use Slim\Flash\Messages;

class Base {
	protected $container;
	protected $view;
	/**
	 * @var Messages
	 */
	protected $flash;

	public function __construct( ContainerInterface $container ) {
		$this->container = $container;
		$this->view = $container->get('renderer');
		$this->flash = $container->get('flash');
	}
}