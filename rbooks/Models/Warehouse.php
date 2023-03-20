<?php

namespace RBooks\Models;

class Warehouse extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'characters', 'address', 'phone', 'fee_percent',  'profit_percent', 'updated_user_id', 'status'
    ];

    protected $statusArr = [
        0 => 'Đang đóng',
        1 => 'Đang hoạt động'
    ];

    public function getStatusTextAttribute()
    {
        return $this->statusArr[$this->status];
    }

    public function productwarehouses()
    {
        return $this->hasMany(ProductWarehouse::class, 'warehouse_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_warehouse')->withPivot('sku', 'sale_price', 'fee', 'profit', 'quantity', 'status', 'addition_info', 'product_id', 'warehouse_id', 'updated_user_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function imports()
    {
        return $this->hasMany(Import::class, 'warehouse_id');
    }

    public function exports()
    {
        return $this->hasMany(Export::class, 'warehouse_id');
    }

    public function transfer_in()
    {
        return $this->hasMany(Transfer::class, 'warehouseto_id');
    }

    public function transfer_out()
    {
        return $this->hasMany(Transfer::class, 'warehousefrom_id');
    }
}
