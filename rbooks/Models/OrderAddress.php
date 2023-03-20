<?php

namespace RBooks\Models;

class OrderAddress extends BaseModel
{
    protected $table = 'order_addresses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'phone', 'email', 'city', 'district', 'ward', 'zipcode', 'address', 'note', 'updated_user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function orders()
    {
        return $this->HasMany(Order::class, 'order_id');
    }
}
