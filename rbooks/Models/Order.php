<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    protected $table = 'orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number', 'customer_id', 'warehouse_id','sub_cover_price' , 'sub_total', 'tax_rate', 'tax_total', 'ship_total', 'total', 'status', 'approved_at', 'note', 'delivery_address_id', 'billing_address_id', 'gift_address_id', 'payment_method', 'updated_user_id', 'customerOrderId', 'orderRef'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vat()
    {
        return $this->hasOne(Vat::class, 'order_id');
    }

    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity','price','sub_total','total','discount','discount_total');
    }

    public function deliveryaddress()
    {
        return $this->belongsTo(OrderAddress::class, 'delivery_address_id', 'id');
    }

    public function billingaddress()
    {
        return $this->belongsTo(OrderAddress::class, 'billing_address_id', 'id');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_address_id', 'id');
    }

    public function export()
    {
        return $this->hasOne(Export::class, 'order_id', 'id');
    }
}
