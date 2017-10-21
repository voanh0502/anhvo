<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:21
 */

namespace Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class AdminProducts extends Base {
	public function index( Request $request, Response $response ) {
		$this->view->render( $response, 'admin/product-list.phtml' );
	}
}