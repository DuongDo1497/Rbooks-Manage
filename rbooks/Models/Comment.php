<?php

namespace RBooks\Models;

class Comment extends BaseModel
{
    protected $table = "comments";

    protected $fillable = ['customer_id', 'headding', 'content', 'rate', 'status'];

   	public function customers()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function answer_comments()
    {
        return $this->hasMany(AnswerComment::class, 'comment_id', 'id');
    }
}
