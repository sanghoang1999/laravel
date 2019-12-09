<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";
    protected $primaryKey="prod_id";
    protected $fillable = [
       'prod_id',
       'prod_name',
       'prod_slug',
       'prod_price',
       'prod_img',
       'prod_warranty',
       'prod_accessories',
       'prod_condition',
       'prod_promotion',
       'prod_status',
       'prod_description',
       'prod_featured',
       'cate_id',
    ];
}
