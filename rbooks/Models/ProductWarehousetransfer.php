<?php

namespace RBooks\Models;

class ProductWarehousetransfer extends BaseModel
{
    protected $table = 'product_warehousetransfers';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'quantity', 'product_id'
    ];

    public function warehousetransfers()
    {
        return $this->belongsTo(Warehousetransfer::class, 'warehousetransfer_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}