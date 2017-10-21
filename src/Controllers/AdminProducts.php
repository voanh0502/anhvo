<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:21
 */

namespace Controllers;


use Models\Product;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminProducts extends Base {
	public function index( Request $request, Response $response ) {
		$this->view->render( $response, 'admin/product-list.phtml', [
			'products' => Product::all(),
			'messages' => $this->flash->getMessage( 'product' )
		] );
	}

	public function edit( Request $request, Response $response, $args ) {
		$id = $args['id'];
		if ( $id === 'add' ) {
			$product = new Product();
		} else {
			$product = Product::find( $id );
		}
		$this->view->render( $response, 'admin/product-add.phtml', [
			'product'  => $product,
			'mode'     => $id === 'add' ? 'add' : 'edit'
		] );
	}

	public function save( Request $request, Response $response, $args ) {
		if ( ! isset( $args['id'] ) ) {
			// create new product
			$product = new Product( $request->getParsedBody() );
			$product->save();
			$this->flash->addMessage( 'product', "Sản phẩm <strong>$product->name</strong> đã được tạo thành công" );

			return $response->withRedirect( '/admin/products', 302 );
		}
	}
}