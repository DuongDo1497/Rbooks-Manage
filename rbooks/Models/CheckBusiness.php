<?php

namespace RBooks\Models;

class CheckBusiness extends BaseModel
{
    protected $table = "ns_checkbusiness"; // Đăng ký công tác

    protected $fillable = ['department_id', 'employee_id', 'checktype_id', 'fromdate', 'todate', 'fromtime', 'totime', 'numday', 'approved_user_id', 'approved_at', 'place', 'description', 'transportation', 'status', 'created_user_id', 'updated_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'approved_user_id');
    }

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function checktype()
    {
        return $this->belongsTo(CheckType::class, 'checktype_id');
    }
}
