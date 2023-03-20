<?php

namespace RBooks\Models;

class ProductWarehouse extends BaseModel
{
    protected $table = 'product_warehouse';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'sku', 'sale_price', 'fee', 'profit', 'quantity', 'status', 'addition_info', 'product_id', 'warehouse_id', 'updated_user_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
