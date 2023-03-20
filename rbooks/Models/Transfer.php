<?php

namespace RBooks\Models;

class Transfer extends BaseModel
{
    protected $table = 'transfers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_transfer', 'code_transfer', 'warehousefrom_id', 'warehouseto_id', 'quantity', 'status', 'sub_total', 'total', 'discount', 'note', 'updated_user_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transfer_product')->withPivot('quantity','price','sub_total','total','discount','discount_total');
    }

    public function warehousefrom()
    {
        return $this->belongsTo(Warehouse::class, 'warehousefrom_id');
    }

    public function warehouseto()
    {
        return $this->belongsTo(Warehouse::class, 'warehouseto_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
