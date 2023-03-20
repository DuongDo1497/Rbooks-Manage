<?php

namespace RBooks\Models;

class CustomerAddress extends BaseModel
{
    protected $table = 'customer_addresses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'ward', 'district', 'city', 'customer_id', 'phone', 'fullname', 'default'
    ];
}
