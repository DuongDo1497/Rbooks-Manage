<?php

namespace RBooks\Models;

class MailSchedule extends BaseModel
{
    protected $table = "mail_schedules";

    protected $fillable = ['customer_id', 'order_number', 'order_date', 'product_id', 'sendmail_product_id', 'sendmail_date',  'sendmail_status', 'created_user_id', 'updated_user_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    public function sendmailProduct()
    {
    	return $this->belongsTo(Product::class, 'sendmail_product_id');
    }
}
