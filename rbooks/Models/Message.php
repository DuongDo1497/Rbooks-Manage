<?php

namespace RBooks\Models;

class Message extends BaseModel
{
    protected $table = "messages";

    protected $fillable = ['email', 'fullname', 'phone', 'address', 'status', 'note'];
}
