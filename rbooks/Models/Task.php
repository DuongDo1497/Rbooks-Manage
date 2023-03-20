<?php

namespace RBooks\Models;

class Task extends BaseModel
{
    protected $table = "ns_tasks";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'module_id', 'division_id', 'module_type', 'taskname', 'tasktype', 'note', 'status', 'filter_status', 'assigned_status', 'progress', 'fromdate', 'todate', 'numday', 'priority', 'description', 'roman_numerals', 'initialization_user_id', 'initialization_at', 'created_user_id', 'updated_user_id'
    ];

    public function detailTasks()
    {
    	return $this->hasMany(DetailTask::class, 'taskid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'initialization_user_id');
    }

}
