<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:17
 */

namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package Models
 *
 * @property integer       $id
 * @property string        $name
 * @property integer       $price
 * @property integer       $saleprice
 * @property-read float    $sale_percentage
 * @property-read boolean  $is_sale
 * @property string        $description
 * @property string        $features
 * @property-read Category $category
 */
class Product extends Model
{
    protected $fillable = ['name', 'price', 'saleprice', 'description', 'features'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('\Models\Category');
    }

    public function getSalePercentageAttribute()
    {
        if ($this->saleprice === null) return 0;
        return (($this->price - $this->saleprice) * 1.0) / $this->price;
    }

    public function getIsSaleAttribute()
    {
        return $this->sale_percentage > 0.001;
    }
}