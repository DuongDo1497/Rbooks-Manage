<?php

namespace RBooks\Models;

class Holiday extends BaseModel
{

    protected $table = "ns_holiday";

    protected $fillable = ['holiday','name','dayname','type','checkholiday','salary'];

}
