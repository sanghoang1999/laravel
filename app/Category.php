<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table ='categories';
    protected $primaryKey="cate_id";
    protected $fillable = [
        'cate_id', 'cate_name', 'cate_slug',
    ];
}
