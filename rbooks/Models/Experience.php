<?php

namespace RBooks\Models;

class Experience extends BaseModel
{
    protected $table = "ns_experiences"; // Kinh nghiệm làm việc

    protected $fillable = ['employee_id', 'fromdate', 'todate', 'companyname', 'major', 'description', 'created_user_id', 'updated_user_id'];

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }
}
