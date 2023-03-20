<?php

namespace RBooks\Models;

class MailProduct extends BaseModel
{
    protected $table = "mail_products";

    protected $fillable = ['name', 'product_id', 'content', 'next_product_id', 'aftersendday', 'ordernum'];

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    public function nextproduct()
    {
    	return $this->belongsTo(Product::class, 'next_product_id');
    }
}
