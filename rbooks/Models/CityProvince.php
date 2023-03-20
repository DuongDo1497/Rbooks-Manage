<?php

namespace RBooks\Models;

class CityProvince extends BaseModel
{
    protected $table = "ns_cityprovinces"; // Tỉnh thành

    protected $fillable = ['name', 'type'];
}
