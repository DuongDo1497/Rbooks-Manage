<?php

namespace RBooks\Models;

class TaskWaitReceive extends BaseModel
{
    protected $table = "ns_task_waitreceive";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'taskname', 'tasktype', 'note', 'priority', 'module_id', 'division_id', 'module_type', 'fromdate', 'todate', 'numday', 'description', 'status', 'filter_status', 'roman_numerals', 'type'
    ];
}
