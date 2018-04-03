<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/2/18
 * Time: 13:06
 */

namespace Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package Models
 * @property string                        $customer_name
 * @property string                        $customer_address
 * @property string                        $customer_phone
 *
 * @property-read Collection|OrderDetail[] $items
 */
class Order extends Model
{
    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }
}