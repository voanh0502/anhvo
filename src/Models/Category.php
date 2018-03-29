<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:19
 */

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('\Models\Products');
    }

}