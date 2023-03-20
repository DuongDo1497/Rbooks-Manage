<?php

namespace RBooks\Models;

class Image_Product extends BaseModel
{
    protected $table = 'image_product';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['image_id', 'product_id','created_at','updated_at','deleted_at'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}