<?php

namespace RBooks\Models;

class DetailTask_RP extends BaseModel
{
    protected $table = "ns_taskchild_rp";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'detailtask_id', 'file_name', 'file_task', 'approved', 'approved_at', 'approved_user_id', 'note',
    ];

    public function detailtask()
    {
    	return $this->belongsTo(DetailTask::class, 'detailtask_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'approved_user_id');
    }
}
