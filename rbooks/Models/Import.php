<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
        'import_date', 'import_code', 'warehouse_import_code', 'quantity', 'sub_total', 'total', 'discount', 'status', 'note', 'supplier_id', 'warehouse_id', 'updated_user_id'
    ];

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
        return $this->belongsToMany(Product::class, 'import_product')->withPivot('quantity','price','sub_total','total','discount','discount_total');
    }

    public function getProductAttribute()
    {
        return $this->products->first();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
