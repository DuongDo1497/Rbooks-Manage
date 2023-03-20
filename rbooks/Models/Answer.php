<?php

namespace RBooks\Models;

class Answer extends BaseModel
{
    protected $table = "answers";

    protected $fillable = ['answer', 'question_id', 'customer_id','status'];

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
