<?php

namespace RBooks\Models;

class Promotion extends BaseModel
{
    protected $table = "email_gift";

    protected $fillable = ['email', 'name', 'phone', 'address'];
}
