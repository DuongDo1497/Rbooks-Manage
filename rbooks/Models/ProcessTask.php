<?php

namespace RBooks\Models;

class ProcessTask extends BaseModel
{
    protected $table = "ns_processtasks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'moduleid', 'taskid', 'status', 'description', 'execute_user_id', 'execute_at', 'created_user_id', 'updated_user_id'
    ];

}
