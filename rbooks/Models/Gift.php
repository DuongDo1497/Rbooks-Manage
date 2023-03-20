<?php

namespace RBooks\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Gift extends BaseModel
{
    use SoftDeletes;
    protected $table = "gifts";

    protected $fillable = ['gift_number','senderName', 'recipientName', 'address', 'phone', 'message', 'customer_id','order_id'];

    public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }
}

