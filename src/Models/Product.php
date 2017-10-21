<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:17
 */

namespace Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model {
	protected $fillable   = [ 'name', 'price', 'saleprice', 'description', 'features' ];
	public    $timestamps = false;
}