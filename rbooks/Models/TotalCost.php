<?php

namespace RBooks\Models;

class TotalCost extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "cp_totalcosts";

    protected $fillable = [
        'name', 'status', 'note', 'created_user_id', 'updated_user_id'
    ];
}
