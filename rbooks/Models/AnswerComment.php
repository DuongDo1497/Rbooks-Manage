<?php

namespace RBooks\Models;

class AnswerComment extends BaseModel
{
    protected $table = "answer_comments";

    protected $fillable = ['answer_cmt', 'comment_id', 'customer_id','status'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
