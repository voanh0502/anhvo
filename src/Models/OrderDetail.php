<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/2/18
 * Time: 13:06
 */

namespace Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderDetail
 * @package Models
 *
 * @property integer      $id
 * @property integer      $order_id
 * @property integer      $product_id
 * @property integer      $quantity
 *
 * @property-read Order   $order
 * @property-read Product $product
 */
class OrderDetail extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}