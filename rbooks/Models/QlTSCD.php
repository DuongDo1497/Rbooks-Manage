<?php

namespace RBooks\Models;

class QlTSCD extends BaseModel
{
    protected $table = "ql_tscds";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'quantity', 'position', 'status', 'note', 'created_user_id', 'updated_user_id'
    ];
}
