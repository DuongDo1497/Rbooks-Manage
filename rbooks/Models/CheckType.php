<?php

namespace RBooks\Models;

class CheckType extends BaseModel
{
    protected $table = "ns_checktypes"; // Lý do nghỉ phép

    protected $fillable = ['signno', 'description', 'showtype'];
}
