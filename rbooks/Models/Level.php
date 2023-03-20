<?php

namespace RBooks\Models;

class Level extends BaseModel
{
    protected $table = "ns_levels"; // Trình độ

    protected $fillable = ['code', 'name', 'typelevel'];
}
