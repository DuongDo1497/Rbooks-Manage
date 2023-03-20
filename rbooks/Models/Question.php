<?php

namespace RBooks\Models;

class Question extends BaseModel
{
    protected $table = "questions";

    protected $fillable = ['customer_id','product_id', 'question', 'status'];

   	public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
