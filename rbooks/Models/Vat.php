<?php

namespace RBooks\Models;

class Vat extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "vats";
    protected $fillable = ['name_company', 'code_vat', 'address_company', 'order_id'];

    public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }
}
