<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export extends BaseModel
{
    use SoftDeletes;
    protected $table = 'exports';

    protected $fillable = [
        'order_id', 'export_code', 'warehouse_export_code', 'quantity', 'sub_total','ship_total','gift_fee', 'total', 'discount', 'status', 'note','supplier_id', 'agencies','address','phone', 'warehouse_id', 'created_user_id', 'updated_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function getSupplierAttribute()
    {
        return $this->suppliers->first();
    }

    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function getWarehouseAttribute()
    {
        return $this->warehouses->first();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'export_product')->withPivot('quantity','price','sub_total','total','discount','discount_total');
    }

    public function getProductAttribute()
    {
        return $this->products->first();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
