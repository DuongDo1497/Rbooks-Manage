<?php

namespace RBooks\Models;

class DetailTask extends BaseModel
{
    protected $table = "ns_detailtasks";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'taskid', 'detailtaskname', 'status', 'progress', 'file_name', 'fromdate', 'todate', 'numday', 'priority', 'description', 'note', 'initialization_user_id', 'initialization_at', 'approved', 'approved_user_id', 'created_user_id', 'updated_user_id'
    ];

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'initialization_user_id');
    }

    public function detailtaskRPs()
    {
        return $this->hasMany(DetailTask_RP::class, 'detailtask_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'taskid');
    }
}
