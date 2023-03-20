<?php

namespace RBooks\Models;

class Coupon extends BaseModel
{
    protected $table = "coupons";

    protected $fillable = ['key', 'percent', 'quantity', 'quantitied', 'description', 'status'];

   	public function customers()
    {
        return $this->belongsToMany(Customer::class, 'coupon_customer')->withPivot('customer_id');
    }
}
